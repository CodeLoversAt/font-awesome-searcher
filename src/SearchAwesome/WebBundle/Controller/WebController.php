<?php

namespace SearchAwesome\WebBundle\Controller;

use JMS\Serializer\SerializationContext;
use SearchAwesome\CoreBundle\Manager\IconManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WebController extends Controller
{
    public function indexAction()
    {
        return $this->render('SearchAwesomeWebBundle:Web:index.html.twig', array());
    }

    public function debugAction(Request $request)
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

        $serializer = $this->get('jms_serializer');
        $json = $serializer->serialize($icons, 'json', SerializationContext::create()->setGroups(['REST']));

        return $this->render('SearchAwesomeWebBundle:Web:debug.html.twig', ['json' => $json]);
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
