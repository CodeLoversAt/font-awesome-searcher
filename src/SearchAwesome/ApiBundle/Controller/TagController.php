<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 14:45
 */

namespace SearchAwesome\ApiBundle\Controller;


use SearchAwesome\CoreBundle\Document\Tag;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use FOS\RestBundle\Controller\Annotations\NoRoute;

class TagController extends RestController
{
    /**
     * @View(templateVar="tag", serializerGroups={"REST"})
     */
    public function cgetAction(Request $request)
    {
        $ids = $request->get('ids', array());
        if (!is_array($ids)) {
            $ids = array();
        }
        return $this->view($this->getTagManager()->findTags($ids));
    }

    /**
     * @View(templateVar="tag", serializerGroups={"REST"})
     */
    public function getAction($id)
    {
        return $this->view($this->getTagManager()->findTag($id));
    }

    /**
     * @param Tag $tag
     *
     * @ParamConverter("newTag", converter="fos_rest.request_body", options={"validator"={"groups"={"newTag"}}})
     * @NoRoute
     */
    public function postAction(Tag $tag, ConstraintViolationListInterface $validationErrors)
    {
        if (0 === count($validationErrors)) {
            $this->getTagManager()->updateTag($tag);

            $view = $this->view($tag);
        } else {
            $errors = array();

            foreach ($validationErrors as $error) {
                /** @var ConstraintViolationInterface $error */
                $propertyPath = $error->getPropertyPath();
                if (!array_key_exists($propertyPath, $errors)) {
                    $errors[$propertyPath] = array();
                }
                $errors[$propertyPath][] = $this->get('translator')->trans($error->getMessageTemplate(), $error->getMessageParameters(), 'validators');
            }

            $view = $this->view(array('errors' => $errors), 400);
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