<?php
namespace AppBundle\Security;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Security\Http\Logout\DefaultLogoutSuccessHandler;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class LogoutListener  extends DefaultLogoutSuccessHandler
{

     /**
     *
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(HttpUtils $httpUtils, TokenStorageInterface $tokenStorage, $targetUrl = '/')
    {
        parent::__construct($httpUtils, $targetUrl);
        $this->tokenStorage = $tokenStorage;
    }


    
    public function onLogoutSuccess(Request $request) 
    {

        $this->tokenStorage->setToken(null);

        return new Response('', 401);

    }
}
