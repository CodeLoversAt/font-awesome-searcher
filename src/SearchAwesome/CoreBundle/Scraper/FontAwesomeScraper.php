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

        $crawler->filter('#wrap > .container > .row > .col-md-4')->each(function(Crawler $col) use (&$icons) {
            $text = trim($col->text());
            list($tmp, $icon, $unicode) = preg_split('/\s+/', $text);

            $data = array(
                'name'     => substr($icon, 3),
                'unicode'  => preg_replace('/[^f\d+]/', '', $unicode),
                'cssClass' => $icon,
                'tags'  => array()
            );

            $parts = explode('-', $data['name']);

            foreach ($parts as $tag) {
                if (strlen($tag) > 1 && !in_array($tag, $data['tags'])) {
                    $data['tags'][] = $tag;
                }
            }

            $icons[] = $data;
        });

        return $icons;
    }
}