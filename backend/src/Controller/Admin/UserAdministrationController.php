<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserAdministrationController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserAdministrationController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/user/{id}/enable", name="enable_user")
     * @IsGranted("ROLE_ADMIN")
     *
     * @param string $id
     *
     * @return Response
     */
    public function enableUser(string $id): Response
    {
        try {
            $this->userRepository->enableUser($id);
        } catch (EntityNotFoundException $e) {
            return $this->json([
                "error" => 'invalid_user',
                "message" => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }

        return new Response();
    }

    /**
     * @Route("/user/{id}/disable", name="disable_user")
     * @IsGranted("ROLE_ADMIN")
     *
     * @param string $id
     *
     * @return Response
     */
    public function disableUser(string $id): Response
    {
        try {
            $this->userRepository->disableUser($id);
        } catch (EntityNotFoundException $e) {
            return $this->json([
                "error" => 'invalid_user',
                "message" => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }

        return new Response();
    }
}
