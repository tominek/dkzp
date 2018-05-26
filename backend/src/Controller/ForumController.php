<?php

namespace App\Controller;

use App\Service\ForumService;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends Controller
{
    /**
     * @var ForumService
     */
    private $forumService;

    public function __construct(ForumService $forumService)
    {
        $this->forumService = $forumService;
    }

    /**
     * @Route("/forum", name="forum_create", methods={"POST"})
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createAction(Request $request): JsonResponse
    {
        try {
            $this->forumService->createFromRequest($request);
        } catch (\InvalidArgumentException $e) {
            return $this->json([
                "error" => "invalid_request",
                "message" => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/forum/{id}", name="forum_update", methods={"PUT"})
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function updateAction(Request $request, string $id): JsonResponse
    {
        try {
            $this->forumService->updateFromRequest($request, $id);
        } catch (EntityNotFoundException $e) {
            return $this->json([], Response::HTTP_NOT_FOUND);
        } catch (\InvalidArgumentException $e) {
            return $this->json([
                "error" => "invalid_request",
                "message" => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/forum/{id}", name="forum_delete", methods={"DELETE"})
     * @IsGranted("ROLE_MODERATOR")
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function deleteAction(string $id): JsonResponse
    {
        try {
            $this->forumService->remove($id);
        } catch (EntityNotFoundException $e) {
            return $this->json([], Response::HTTP_NOT_FOUND);
        }

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/forum", name="forum_list", methods={"GET"})
     * @IsGranted("ROLE_USER")
     *
     * @return JsonResponse
     */
    public function listAction(): JsonResponse
    {
        $data = $this->forumService->getAll();

        return $this->json($data, Response::HTTP_OK);
    }
}
