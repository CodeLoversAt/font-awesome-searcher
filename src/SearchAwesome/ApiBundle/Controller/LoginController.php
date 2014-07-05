<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 05.07.14
 * @time 19:41
 */

namespace SearchAwesome\ApiBundle\Controller;


use FOS\RestBundle\Util\Codes;
use SearchAwesome\CoreBundle\Document\User;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends RestController
{
    public function loginAction(Request $request)
    {
        $sc = $this->get('security.context');
        $session = $request->getSession();

        if ($sc->isGranted('IS_AUTHENTICATED_FULLY')) {
            /** @var User $user */
            $user = $this->getUser();
            $output = array(
                'id'     => $session->getId(),
                'userId' => $user->getId(),
                'role'   => reset($user->getRoles())
            );

            $view = $this->view($output);
        } else {
            $view = $this->view(null, Codes::HTTP_UNAUTHORIZED);
        }

        return $view;
    }
} 