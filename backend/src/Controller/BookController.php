<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends FOSRestController
{
    /**
     * @var BookRepository
     */
    private $bookRepository;

    /**
     * BookController constructor.
     */
    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @Route("/book", methods={"GET"}, name="books")
     * @param Request $request
     * @return JsonResponse
     */
    public function getAll(Request $request): JsonResponse
    {
        $maxLimit = 1;
        $limit = (int) $request->query->get('limit');
        if ($limit > $maxLimit) {
            $limit = $maxLimit;
        }

        $offset = (int) $request->query->get('offset');

        return $this->json(
            $this->bookRepository->findBy(
                [],
                [],
                $limit ? $limit : $maxLimit,
                $offset ? $offset : null
            )
        );
    }
}
