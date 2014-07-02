<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 16:43
 */

namespace Backend\ApiBundle\Controller;


use Backend\CoreBundle\Document\Site;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SiteController extends RestController
{
    /**
     * @View(templateVar="site", serializerGroups={"REST"})
     */
    public function cgetAction()
    {
        $sites = $this->getSiteManager()->findSites();

        return $this->view($sites);
    }

    /**
     * @View(templateVar="site")
     */
    public function getAction($id)
    {
        return $this->view($this->getSiteManager()->findSite($id));
    }

    /**
     * @param Site $site
     *
     * @ParamConverter("site", converter="fos_rest.request_body")
     */
    public function postAction(Site $site, ConstraintViolationListInterface $validationErrors)
    {
        if (0 === count($validationErrors)) {
            $this->getSiteManager()->updateSite($site);

            $view = $this->routeRedirectView('get_site', array('id' => $site->getId()));
        } else {
            throw new HttpException(400, 'User is not valid');
        }

        return $view;
    }

    /**
     * @param Site $site
     *
     * @ParamConverter("site", converter="fos_rest.request_body")
     */
    public function putAction(Site $site, ConstraintViolationListInterface $validationErrors)
    {

    }

    public function deleteAction($id)
    {

    }
} 