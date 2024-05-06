<?php

namespace App\Security;

use App\Entity\User;
use App\Exception\DatabaseObjectNotFoundException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class KeycloakAuthenticator extends AbstractAuthenticator
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private ParameterBagInterface $parameterBag,
    ) {}

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization');
    }

    public function authenticate(Request $request): Passport
    {
        // Get token from header
        $jwtToken = $request->headers->get('Authorization');
        if (false === str_starts_with($jwtToken, 'Bearer ')) {
            throw new AuthenticationException('Invalid token');
        }

        $jwtToken = str_replace('Bearer ', '', $jwtToken);

        try {
            $decodedToken = JWT::decode($jwtToken, $this->getJwks());
        } catch (Exception $e) {
            throw new AuthenticationException($e->getMessage());
        }

        return new SelfValidatingPassport(
            new UserBadge($decodedToken->email, function (string $keycloakUserEmail) {
                try {
                    $user = $this->userRepository->findByEmailOrThrowException($keycloakUserEmail);
                } catch (DatabaseObjectNotFoundException $exception) {
                    $user = new User($keycloakUserEmail);
                    $this->entityManager->persist($user);
                    $this->entityManager->flush();
                }

                return $user;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'error' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    private function getJwks(): array
    {
        $jwkData = json_decode(file_get_contents(sprintf(
            '%s/realms/%s/protocol/openid-connect/certs',
            trim($this->parameterBag->get('keycloak_url'), '/'),
            $this->parameterBag->get('keycloak_realm')
        )), true, 512, JSON_THROW_ON_ERROR);

        return JWK::parseKeySet($jwkData);
    }

}