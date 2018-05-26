<?php

namespace App\Service;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class BookCreatorService
{
    /**
     * @var BookRepository
     */
    private $bookRepository;

    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * BookCreatorService constructor.
     *
     * @param BookRepository $bookRepository
     * @param AuthorRepository $authorRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(BookRepository $bookRepository, AuthorRepository $authorRepository, CategoryRepository $categoryRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->authorRepository = $authorRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Request $request
     *
     * @return Book
     *
     * @throws \InvalidArgumentException
     */
    public function createFromRequest(Request $request)
    {
        try {
            $data = json_decode($request->getContent(), true);
            $this->validateCreateData($data);
            $author = $this->authorRepository->findIfExists($data['author']);

            $categories = [];
            foreach ($data['categories'] as $categoryId) {
                $categories = $this->categoryRepository->findIfExists($categoryId);
            }
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid request body. ' . $e->getMessage());
        }

        $book = $this->bookRepository->create(
            $data['name'],
            $author,
            $categories
        );
        $this->bookRepository->save($book);

        return $book;
    }

    private function validateCreateData($data)
    {
        $validator = Validation::createValidator();

        $constraint = new Assert\Collection(array(
            'name' => new Assert\NotBlank(),
            'author' => new Assert\NotBlank(),
            'categories' => new Assert\Collection()
        ));

        $violations = $validator->validate($data, $constraint);

        if ($violations->count() > 0) {
            throw new \InvalidArgumentException("Missing required parameters. Required: name, author");
        }
    }
}
