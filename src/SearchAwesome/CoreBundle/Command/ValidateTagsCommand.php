<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 05.07.14
 * @time 17:46
 */

namespace SearchAwesome\CoreBundle\Command;


use SearchAwesome\CoreBundle\Document\TagUsage;
use SearchAwesome\CoreBundle\Manager\IconManagerInterface;
use SearchAwesome\CoreBundle\Manager\TagManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ValidateTagsCommand extends ContainerAwareCommand
{
    /**
     * @var TagManagerInterface
     */
    private $manager;

    /**
     * @var IconManagerInterface
     */
    private $iconManager;

    protected function configure()
    {
        $this->setName('admin:tags:validate')
            ->setDescription('This command sets the "validated" property of <error>ALL</error> tags to "true"')
            ->addOption('force', null, InputOption::VALUE_NONE);
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->manager = $this->getContainer()->get('tag_manager');
        $this->iconManager = $this->getContainer()->get('icon_manager');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getOption('force')) {
            $output->writeln('usage:');
            $output->writeln(sprintf("<comment>%s --force</comment>", $this->getName()));
            return;
        }

        foreach ($this->manager->findTags() as $tag) {
            $tag->setValidated(true);
            $this->manager->updateTag($tag, false);
        }

        foreach ($this->iconManager->findIcons() as $icon) {
            foreach ($icon->getTags() as $tagUsage) {
                /** @var TagUsage $tagUsage */
                $tagUsage->setValidated(true);
            }
            $this->iconManager->updateIcon($icon, false);
        }

        $this->manager->flushChanges();
    }
}