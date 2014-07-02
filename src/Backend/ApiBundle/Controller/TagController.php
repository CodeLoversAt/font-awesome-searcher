<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 14:45
 */

namespace Backend\ApiBundle\Controller;


use Backend\CoreBundle\Document\Tag;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class TagController extends RestController
{
    /**
     * @View()
     */
    public function cgetAction()
    {
        return $this->view($this->getTagManager()->findTags());
    }

    /**
     * @View()
     */
    public function getAction($id)
    {
        return $this->view($this->getTagManager()->findTag($id));
    }

    /**
     * @param Tag $tag
     *
     * @ParamConverter("tag", converter="fos_rest.request_body")
     */
    public function postAction(Tag $tag, ConstraintViolationListInterface $validationErrors)
    {
        if (0 === count($validationErrors)) {
            $this->getTagManager()->updateTag($tag);

            $view = $this->routeRedirectView('get_tag', array('id' => $tag->getId()));
        } else {
            throw new HttpException(400, 'User is not valid');
        }

        return $view;
    }

    /**
     * @param Tag $tag
     *
     * @ParamConverter("tag", converter="fos_rest.request_body")
     */
    public function putAction(Tag $tag, ConstraintViolationListInterface $validationErrors)
    {

    }

    public function deleteAction($id)
    {

    }
} 