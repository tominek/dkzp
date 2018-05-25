<?php

namespace App\Controller;

use App\Entity\Book;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends FOSRestController
{
    /**
     * Create Book.
     * @FOSRest\Post("/book")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createBook(Request $request)
    {
        $book = new Book();
        $book->setName($request->get('name'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($book);
        $em->flush();

        return $this->view($book, Response::HTTP_CREATED)->getResponse();
    }
}
