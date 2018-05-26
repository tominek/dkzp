<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends Controller
{
    /** @var UserRepository */
    private $userRepository;

    /** @var BookRepository */
    private $bookRepository;

    public function __construct(UserRepository $userRepository, BookRepository $bookRepository)
    {
        $this->userRepository = $userRepository;
        $this->bookRepository = $bookRepository;
    }

    /**
     * @Route("/favorite/{id}", name="favorite_add", methods={"POST"})
     * @IsGranted("ROLE_USER")
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function addBook(string $id)
    {
        $book = $this->bookRepository->find($id);
        if (!$book) {
            return $this->json([
                "error" => "invalid_request",
                "message" => "Book with id ".$id." not found!"
            ], Response::HTTP_BAD_REQUEST);
        }

        /** @var User $user */
        $user = $this->getUser();
        $user->addFavoriteBook($book);
        $this->userRepository->save($user);

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/favorite/{id}", name="favorite_remove", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function removeBook(string $id)
    {
        $book = $this->bookRepository->find($id);
        if (!$book) {
            return $this->json([
                "error" => "invalid_request",
                "message" => "Book with id ".$id." not found!"
            ], Response::HTTP_BAD_REQUEST);
        }

        /** @var User $user */
        $user = $this->getUser();
        $user->removeFavoriteBook($book);
        $this->userRepository->save($user);

        return $this->json([], Response::HTTP_OK);
    }
}
