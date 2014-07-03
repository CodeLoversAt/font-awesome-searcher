<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 16:43
 */

namespace SearchAwesome\ApiBundle\Controller;


use SearchAwesome\CoreBundle\Document\Icon;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class IconController extends RestController
{
    /**
     * @View(templateVar="icon", serializerGroups={"REST"})
     */
    public function cgetAction(Request $request)
    {
        $search = $request->query->get('search', null);

        if ($search) {
            $icons = $this->getIconManager()->findIconsByTagName($search);
        } else {
            $ids = $request->query->get('ids', array());
            if (!is_array($ids)) {
                $ids = array();
            }
            $icons = $this->getIconManager()->findIcons($ids);
        }

        return $this->view($icons);
    }

    /**
     * @View(templateVar="icon")
     */
    public function getAction($id)
    {
        $icon = $this->getIconManager()->findIcon($id);

        return $this->view($icon);
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