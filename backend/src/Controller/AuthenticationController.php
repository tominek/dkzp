<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticationController extends Controller
{
    /**
     * @var AuthenticationUtils
     */
    private $authUtils;

    /**
     * AuthenticationController constructor.
     *
     * @param AuthenticationUtils $authUtils
     */
    public function __construct(AuthenticationUtils $authUtils)
    {
        $this->authUtils = $authUtils;
    }

    /**
     * @Route("/login", name="login", methods={"POST"})
     *
     * @return Response
     */
    public function login()
    {
        $user = $this->getUser();
        if (empty($user)) {
            return $this->json([
                "error" => "invalid_credentials"
            ], Response::HTTP_UNAUTHORIZED);
        }
        return $this->json($user);
    }

    /**
     * @Route("/logout", name="logout")
     *
     * @return Response
     */
    public function logout()
    {
        return new Response();
    }
}
