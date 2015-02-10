<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 10.02.15
 * @time 21:13
 */

namespace SearchAwesome\CoreBundle\Command;


use GuzzleHttp\Client;
use JMS\Serializer\SerializerInterface;
use SearchAwesome\CoreBundle\Manager\IconManagerInterface;
use SearchAwesome\CoreBundle\Manager\SiteManagerInterface;
use SearchAwesome\CoreBundle\Manager\TagManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends ContainerAwareCommand
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var TagManagerInterface
     */
    private $tagManager;

    /**
     * @var IconManagerInterface
     */
    private $iconManager;

    /**
     * @var SiteManagerInterface
     */
    private $siteManager;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var \ReflectionProperty
     */
    private $tagIdProperty;

    /**
     * @var \ReflectionProperty
     */
    private $iconIdProperty;

    /**
     * @var \ReflectionProperty
     */
    private $siteIdProperty;

    protected function configure()
    {
        $this->setName('sa:import')
            ->setDescription('imports data from another search-awesome installation')
            ->addArgument('url', InputArgument::OPTIONAL, 'the base URL of the installation', 'https://search-awesome.com');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->baseUrl = $input->getArgument('url');

        if ('/' === substr($this->baseUrl, -1)) {
            $this->baseUrl = substr($this->baseUrl, 0, -1);
        }

        $container = $this->getContainer();
        $this->tagManager = $container->get('tag_manager');
        $this->iconManager = $container->get('icon_manager');
        $this->siteManager = $container->get('site_manager');
        $this->serializer = $container->get('jms_serializer');
        $this->client = new Client(['base_url' => $this->baseUrl]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // import tags
        $this->importTags($output);

        // import sites
        $this->importSites($output);

        // import icons
        $this->importIcons($output);
    }

    private function getData($path)
    {
        $response = $this->client->get($path);
        return $response->json();
    }

    private function getTagIdProperty()
    {
        if (null === $this->tagIdProperty) {
            $reflClass = new \ReflectionClass('SearchAwesome\CoreBundle\Document\Tag');
            $this->tagIdProperty = $reflClass->getProperty('id');
            $this->tagIdProperty->setAccessible(true);
        }

        return $this->tagIdProperty;
    }

    private function getIconIdProperty()
    {
        if (null === $this->iconIdProperty) {
            $reflClass = new \ReflectionClass('SearchAwesome\CoreBundle\Document\Icon');
            $this->iconIdProperty = $reflClass->getProperty('id');
            $this->iconIdProperty->setAccessible(true);
        }

        return $this->iconIdProperty;
    }

    private function getSiteIdProperty()
    {
        if (null === $this->siteIdProperty) {
            $reflClass = new \ReflectionClass('SearchAwesome\CoreBundle\Document\Site');
            $this->siteIdProperty = $reflClass->getProperty('id');
            $this->siteIdProperty->setAccessible(true);
        }

        return $this->siteIdProperty;
    }

    private function importTags(OutputInterface $output)
    {
        $tags = $this->getData('/api/tags');

        foreach ($tags as $data) {
            $tag = $this->tagManager->createTag();
            $this->getTagIdProperty()->setValue($tag, $data['id']);
            $tag->setValidated($data['isValidated'])
                ->setName($data['name']);

            $created = new \DateTime($data['createdAt']);
            $tag->setCreatedAt($created);

            if (isset($data['updatedAt'])) {
                $updated = new \DateTime($data['updatedAt']);

                $tag->setUpdatedAt($updated);
            }

            $this->tagManager->updateTag($tag);

            $output->writeln(sprintf('<info>imported Tag with name %s and id %s</info>', $tag->getName(), $tag->getId()));
        }
    }

    private function importSites(OutputInterface $output)
    {
        $sites = $this->getData('/api/sites');

        foreach ($sites as $data) {
            $site = $this->siteManager->createSite();
            $this->getSiteIdProperty()->setValue($site, $data['id']);

            $site->setName($data['name'])
                ->setUrl($data['url'])
                ->setDetailsPath($data['detailsPath']);

            $site = $this->siteManager->updateSite($site);

            $output->writeln(sprintf('<info>imported site with name "%s" and id "%s"</info>', $site->getName(), $site->getId()));
        }

    }

    private function importIcons(OutputInterface $output)
    {
        $icons = $this->getData('/api/icons');

        foreach ($icons as $data) {
            $icon = $this->iconManager->createIcon();

            $this->getIconIdProperty()->setValue($icon, $data['id']);

            $icon->setName($data['name'])
                ->setCssClass($data['cssClass'])
                ->setCreatedAt(new \DateTime($data['createdAt']))
                ->setUnicode($data['unicode'])
                ->setSite($this->getSite($data['site']));

            foreach ($data['tags'] as $tagId) {
                $tag = $this->getTag($tagId);
                $icon->addTag($tag, $tag->isValidated());
            }

            foreach ($data['aliases'] as $alias) {
                $icon->addAlias($alias);
            }

            if (isset($data['updatedAt'])) {
                $icon->setUpdatedAt(new \DateTime($data['updatedAt']));
            }

            $icon = $this->iconManager->updateIcon($icon);

            $output->writeln(sprintf('<info>imported icon with name %s and id %s</info>', $icon->getName(), $icon->getId()));
        }

    }

    /**
     * @param string $id
     *
     * @return \SearchAwesome\CoreBundle\Document\Site
     */
    private function getSite($id)
    {
        return $this->siteManager->findSite($id);
    }

    /**
     * @param string $id
     *
     * @return \SearchAwesome\CoreBundle\Document\Tag
     */
    private function getTag($id)
    {
        return $this->tagManager->findTag($id);
    }
}