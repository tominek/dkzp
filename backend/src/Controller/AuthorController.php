<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use App\Service\AuthorCreatorService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends Controller
{
    /**
     * @var AuthorCreatorService
     */
    private $authorCreatorService;

    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    /**
     * AuthorController constructor.
     *
     * @param AuthorCreatorService $authorCreatorService
     * @param AuthorRepository $authorRepository
     */
    public function __construct(AuthorCreatorService $authorCreatorService, AuthorRepository $authorRepository)
    {
        $this->authorCreatorService = $authorCreatorService;
        $this->authorRepository = $authorRepository;
    }

    /**
     * @Route("/author", name="list_authors", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function listAction()
    {
        return $this->json($this->authorRepository->findAll());
    }

    /**
     * @Route("/author", name="create_author", methods={"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        try {
            $author = $this->authorCreatorService->createFromRequest($request);
        } catch (\InvalidArgumentException $e) {
            return $this->json([
                "error" => "invalid_request",
                "message" => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($author, Response::HTTP_CREATED);
    }
}
