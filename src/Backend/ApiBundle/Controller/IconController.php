<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 16:43
 */

namespace Backend\ApiBundle\Controller;


use Backend\CoreBundle\Document\Icon;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class IconController extends RestController
{
    /**
     * @View(templateVar="icon", serializerGroups={"REST"})
     */
    public function cgetAction()
    {
        $icons = $this->getIconManager()->findIcons();

        return $this->view($icons);
    }

    /**
     * @View(templateVar="icon")
     */
    public function getAction($id)
    {
        return $this->view($this->getIconManager()->findIcon($id));
    }

    /**
     * @param Icon $icon
     *
     * @ParamConverter("icon", converter="fos_rest.request_body")
     */
    public function postAction(Icon $icon, ConstraintViolationListInterface $validationErrors)
    {
        if (0 === count($validationErrors)) {
            $this->getIconManager()->updateIcon($icon);

            $view = $this->routeRedirectView('get_icon', array('id' => $icon->getId()));
        } else {
            throw new HttpException(400, 'User is not valid');
        }

        return $view;
    }

    /**
     * @param Icon $icon
     *
     * @ParamConverter("icon", converter="fos_rest.request_body")
     */
    public function putAction(Icon $icon, ConstraintViolationListInterface $validationErrors)
    {

    }

    public function deleteAction($id)
    {

    }
} 