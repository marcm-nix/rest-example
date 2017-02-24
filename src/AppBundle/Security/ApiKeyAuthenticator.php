<?php
namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface
{


    public $em;

    public function __construct($em)
    {
        $this->em = $em;
    }


    public function createToken(Request $request, $providerKey)
    {
            /* // look for an token query parameter */
            $token = $request->query->get('token'); 

            if (!$token)
                throw new BadCredentialsException();
        

            $dateNow = new \DateTime();

            $user = $this->em->getRepository('AppBundle:Users')
                ->createQueryBuilder('u')
                ->where('u.token = :token')
                ->andWhere(':date between u.dateFrom and u.dateTo')
                ->setParameter('date', $dateNow)
                ->setParameter('token', $token)
                ->getQuery()->getOneOrNullResult();

            if (!$user)
                throw new BadCredentialsException();

            return new PreAuthenticatedToken(
                $user->getName(),
                $token,
                $providerKey
            );



    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey) {
        if (!$userProvider instanceof ApiKeyUserProvider) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The user provider must be an instance of ApiKeyUserProvider (%s was given).',
                    get_class($userProvider)
                )
            );
        }

        $token = $token->getCredentials();
        $username = $userProvider->getUsernameForApiKey($token);

        if (!$username) {
            // message will be returned to the client
            throw new CustomUserMessageAuthenticationException(
                sprintf('API Key "%s" does not exist.', $token)
            );
        }
        $user = $userProvider->loadUserByUsername($username);

        return new PreAuthenticatedToken(
            $user,
            $token,
            $providerKey,
            $user->getRoles()
        );
    }
}
