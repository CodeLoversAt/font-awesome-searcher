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
    public function loginStatusAction(Request $request)
    {
        $sc = $this->get('security.context');
        $session = $request->getSession();

        if ($sc->isGranted('IS_AUTHENTICATED_FULLY')) {
            /** @var User $user */
            $token = $sc->getToken();
            $user = $token->getUser();
            $roles = $token->getRoles();
            $outputRoles = array();
            $translator = $this->get('translator');

            foreach ($roles as $role) {
                $outputRoles[] = $translator->trans($role->getRole(), array(), 'roles');
            }
            $output = array(
                'id'     => $session->getId(),
                'userId' => $user->getId(),
                'roles'  => $outputRoles,
                'email'  => $user->getEmail()
            );

            $view = $this->view($output);
        } else {
            $view = $this->view(null);
        }

        return $view;
    }
} 