<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Service\BookCreatorService;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends FOSRestController
{
    /**
     * @var BookRepository
     */
    private $bookRepository;

    /**
     * @var BookCreatorService
     */
    private $bookCreatorService;

    /**
     * BookController constructor.
     *
     * @param BookRepository $bookRepository
     * @param BookCreatorService $bookCreatorService
     */
    public function __construct(BookRepository $bookRepository, BookCreatorService $bookCreatorService)
    {
        $this->bookRepository = $bookRepository;
        $this->bookCreatorService = $bookCreatorService;
    }

    /**
     * @Route("/book", methods={"GET"}, name="books")
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getAll(Request $request): JsonResponse
    {
        $maxLimit = 50;
        $limit = (int)$request->query->get('limit');
        if ($limit > $maxLimit) {
            $limit = $maxLimit;
        }

        $offset = (int)$request->query->get('offset');

        return $this->json(
            $this->bookRepository->findBy(
                [],
                [],
                $limit ? $limit : $maxLimit,
                $offset ? $offset : null
            )
        );
    }

    /**
     * @Route("/book", methods={"POST"}, name="create_book")
     * @IsGranted("ROLE_ADMIN")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createBook(Request $request): JsonResponse
    {
        try {
            $book = $this->bookCreatorService->createFromRequest($request);
        } catch (\InvalidArgumentException $e) {
            return $this->json([
                "error" => "invalid_request",
                "message" => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($book, Response::HTTP_CREATED);
    }
}
