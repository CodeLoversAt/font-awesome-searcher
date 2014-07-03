<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 17:44
 */

namespace SearchAwesome\CoreBundle\Command;


use SearchAwesome\CoreBundle\Manager\SiteManagerInterface;
use SearchAwesome\CoreBundle\Scraper\Scraper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScrapeCommand extends ContainerAwareCommand
{
    /**
     * @var SiteManagerInterface
     */
    private $siteManager;

    /**
     * @var Scraper
     */
    private $scraper;

    protected function configure()
    {
        $this->setName('sa:scrape')
            ->setDescription('Scrapes all sites and updates icons');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->siteManager->findSites() as $site) {
            $this->scraper->scrape($site, '4.1.0');
        }
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $this->siteManager = $container->get('site_manager');
        $this->scraper = $container->get('backend_core.scraper');
    }
}