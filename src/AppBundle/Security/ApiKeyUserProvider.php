<?php
namespace AppBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class ApiKeyUserProvider implements UserProviderInterface
{



    public function __construct($em)
    {
        $this->em = $em;
    }


    public function getUsernameForApiKey($token)
    {

        $user = $this->em->getRepository("AppBundle:Users")->findOneBy([ 'token' => trim($token) ]);

        if(empty($user)) {
            return null;
        }

        return $user;

    }

    public function loadUserByUsername($user)
    {
        return new User(
            $user->getName(),
            null,
            $user->getRoles()
        );
    }

    public function refreshUser(UserInterface $user)
    {
        // it's not needed auth is stateless
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}
