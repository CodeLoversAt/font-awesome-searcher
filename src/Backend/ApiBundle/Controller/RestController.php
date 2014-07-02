<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 15:17
 */

namespace Backend\ApiBundle\Controller;


use Backend\CoreBundle\Manager\IconManagerInterface;
use Backend\CoreBundle\Manager\SiteManagerInterface;
use Backend\CoreBundle\Manager\TagManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

abstract class RestController extends FOSRestController implements ClassResourceInterface
{
    /**
     *
     * @return TagManagerInterface
     */
    protected function getTagManager()
    {
        return $this->get('tag_manager');
    }

    /**
     *
     * @return SiteManagerInterface
     */
    protected function getSiteManager()
    {
        return $this->get('site_manager');
    }

    /**
     *
     * @return IconManagerInterface
     */
    protected function getIconManager()
    {
        return $this->get('icon_manager');
    }
}