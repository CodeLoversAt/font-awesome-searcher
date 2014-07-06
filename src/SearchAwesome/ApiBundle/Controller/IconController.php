<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 16:43
 */

namespace SearchAwesome\ApiBundle\Controller;


use FOS\RestBundle\Util\Codes;
use SearchAwesome\ApiBundle\Form\Model\DeleteTag;
use SearchAwesome\CoreBundle\Document\Tag;
use SearchAwesome\CoreBundle\Document\Icon;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\NoRoute;

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

        if (!$icon) {
            throw $this->createNotFoundException();
        }

        return $this->view($icon);
    }

    /**
     * @param Icon $icon
     *
     * @ParamConverter("icon", converter="fos_rest.request_body")
     * @NoRoute()
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
     * adds a new Tag to an Icon
     *
     * @param string $id
     * @param Tag $tagModel
     *
     * @param \Symfony\Component\Validator\ConstraintViolationListInterface $validationErrors
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \FOS\RestBundle\View\View
     */
    public function postTagAction($id, Request $request)
    {
        $icon = $this->getIconManager()->findIcon($id);

        if (!$icon) {
            throw $this->createNotFoundException();
        }
        $tagModel = new Tag();

        $form = $this->createForm('sa_tag', $tagModel);
        $data = $request->request->all();
        $form->submit($data);

        if ($form->isValid()) {
            $tagManager = $this->getTagManager();
            $validated = $this->get('security.context')->isGranted('ROLE_ADMIN');
            if (!($tag = $tagManager->findTagByName($tagModel->getName()))) {
                // new tag => persist it
                $tagModel->setValidated($validated);
                $tagManager->updateTag($tagModel);
                $tag = $tagModel;
            }
            $icon->addTag($tag, $validated);
            $this->getIconManager()->updateIcon($icon);

            $view = $this->view($tag);
        } else {
            $view = $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        return $view;
    }

    public function deleteTagAction($id, $tagId, Request $request)
    {
        $iconManager = $this->getIconManager();
        $icon = $iconManager->findIcon($id);

        if (!$icon) {
            throw $this->createNotFoundException('icon not found');
        }

        $tagManager = $this->getTagManager();
        $tag = $tagManager->findTag($tagId);

        if (!$tag) {
            throw $this->createNotFoundException('tag not found');
        }

        $model = new DeleteTag();

        $form = $this->createForm('delete_tag', $model);
        $captcha = $request->query->get('recaptcha', null);

        if (null === $captcha) {
            $data = array();
        } else {
            if (is_string($captcha)) {
                $captcha = json_decode($captcha, true);
            }
            $data = array(
                'recaptcha' => $captcha
            );
        }
        $form->submit($data);


        if ($form->isValid()) {
            $icon->removeTag($tag, $this->get('security.context')->isGranted('ROLE_ADMIN'));
            $iconManager->updateIcon($icon);

            $view = $this->view($icon);
        } else {
            $view = $this->view($form, Codes::HTTP_BAD_REQUEST);
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