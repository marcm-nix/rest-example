<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Admin controller.
 *
 */
class AdminController extends Controller
{


    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function dashboardAction()
    {
        return $this->render('AppBundle:Admin:dashboard.html.twig');
    }



    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request)
    {
        $this->get('security.token_storage')->setToken(null);
        $request->getSession()->invalidate();

        return new RedirectResponse($this->generateUrl('homepage'));


    }



    /**
     * @Route("/admin/ajax-get-token", name="admin_ajax_get_token")
     */
    public function ajaxGetTokenAction()
    {
        return new JsonResponse(['status' => true, 'token' => $this->_getToken()]);
    }



    private function _getToken()
    {
        return bin2hex(openssl_random_pseudo_bytes(28)) . time();
    }


}
