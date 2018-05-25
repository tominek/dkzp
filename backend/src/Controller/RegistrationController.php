<?php

namespace App\Controller;

use App\Security\UserProvider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends Controller
{
    /**
     * @var UserProvider
     */
    private $userProvider;

    /**
     * RegistrationController constructor.
     *
     * @param UserProvider $userProvider
     */
    public function __construct(UserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /**
     * @Route("/register", name="registration", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function register(Request $request): Response
    {
        try {
            $this->userProvider->createFromRequest($request);
        } catch (\InvalidArgumentException $e) {
            return $this->json(["message" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new Response(null, Response::HTTP_CREATED);
    }
}
