<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 18:01
 */

namespace SearchAwesome\CoreBundle\Scraper;


use SearchAwesome\CoreBundle\Document\Site;
use SearchAwesome\CoreBundle\Manager\IconManagerInterface;
use SearchAwesome\CoreBundle\Manager\TagManagerInterface;

class Scraper
{
    /**
     * @var TagManagerInterface
     */
    private $tagManager;

    /**
     * @var IconManagerInterface
     */
    private $iconManager;

    /**
     * @var FontAwesomeScraper
     */
    private $fontAwesomeScraper;

    /**
     * @param IconManagerInterface $iconManager
     * @param TagManagerInterface $tagManager
     */
    public function __construct(IconManagerInterface $iconManager, TagManagerInterface $tagManager, FontAwesomeScraper $fontAwesomeScraper)
    {
        $this->iconManager = $iconManager;
        $this->tagManager = $tagManager;
        $this->fontAwesomeScraper = $fontAwesomeScraper;
    }

    public function scrape(Site $site, $version)
    {
        $icons = $this->fontAwesomeScraper->scrape($site, $version);

        foreach ($icons as $data) {
            $name = $data['name'];
            $icon = $this->getIcon($name, $site);
            $icon->setCssClass($data['cssClass'])
                ->setUnicode($data['unicode']);

            foreach ($data['tags'] as $tagName) {
                $icon->addTag($this->getTag($tagName), true);
            }

            foreach ($data['aliases'] as $alias) {
                $icon->addAlias($alias);
            }

            $this->iconManager->updateIcon($icon);
        }
    }

    /**
     * @param string $name
     *
     * @return \SearchAwesome\CoreBundle\Document\Tag
     */
    private function getTag($name)
    {
        if (!($tag = $this->tagManager->findTagByName($name))) {
            $tag = $this->tagManager->createTag();
            $tag->setName($name)
                ->setValidated(true);
            $this->tagManager->updateTag($tag);
        }

        return $tag;
    }

    private function getIcon($name, Site $site)
    {
        if (!($icon = $this->iconManager->findIconByName($name, $site))) {
            $icon = $this->iconManager->createIcon();
            $site->addIcon($icon);
            $icon->setName($name);
        }

        return $icon;
    }
}