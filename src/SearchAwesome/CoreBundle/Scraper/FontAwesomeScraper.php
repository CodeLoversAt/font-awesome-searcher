<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 17:19
 */

namespace SearchAwesome\CoreBundle\Scraper;


use Goutte\Client;
use SearchAwesome\CoreBundle\Document\Site;
use SearchAwesome\CoreBundle\Manager\IconManagerInterface;
use SearchAwesome\CoreBundle\Manager\TagManagerInterface;
use Symfony\Component\DomCrawler\Crawler;

class FontAwesomeScraper
{
    public function scrape(Site $site, $version)
    {
        $client = new Client();
        $crawler = $client->request('GET', $site->getUrl() . 'cheatsheet/');
        $scraper = $this;
        $icons = array();
        $aliasBuffer = array();
        $aliasMap = array();

        $crawler->filter('#wrap > .container > .row > .col-md-4')->each(function(Crawler $col) use (&$icons, &$aliasMap, &$aliasBuffer) {
            $text = trim($col->text());
            list($tmp, $icon, $unicode) = preg_split('/\s+/', $text);

            preg_match('/\[\&#x(f[0-9a-f]+);/', $text, $matches);

            if (count($matches) > 1) {
                $unicode = end($matches);
            }
            $data = array(
                'name'     => substr($icon, 3),
                'unicode'  => $unicode,
                'cssClass' => $icon,
                'tags'     => array(),
                'aliases'  => array(),
            );

            $parts = explode('-', $data['name']);

            foreach ($parts as $tag) {
                if (strlen($tag) > 1 && !in_array($tag, $data['tags'])) {
                    $data['tags'][] = $tag;
                }
            }


            if (false !== strpos($text, 'alias')) {
                // it's an alias
                if (array_key_exists($unicode, $aliasMap)) {
                    $idx = $aliasMap[$unicode];
                    $icons[$idx]['aliases'][] = $data['cssClass'];

                    foreach ($data['tags'] as $tag) {
                        if (!in_array($tag, $icons[$idx]['tags'])) {
                            $icons[$idx]['tags'][] = $tag;
                        }
                    }
                } else {
                    // original hasn't occured yet
                    $aliasBuffer[] = $data;
                }
            } else {
                $aliasMap[$unicode] = count($icons);

                $icons[] = $data;
            }
        });

        // map the rest of the aliases
        foreach ($aliasBuffer as $data) {
            if (array_key_exists($data['unicode'], $aliasMap)) {
                $idx = $aliasMap[$data['unicode']];
                $icons[$idx]['aliases'][] = $data['cssClass'];

                foreach ($data['tags'] as $tag) {
                    if (!in_array($tag, $icons[$idx]['tags'])) {
                        $icons[$idx]['tags'][] = $tag;
                    }
                }
            }
        }

        return $icons;
    }
}