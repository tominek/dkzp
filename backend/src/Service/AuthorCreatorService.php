<?php

namespace App\Service;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class AuthorCreatorService
{
    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    /**
     * AuthorCreatorService constructor.
     *
     * @param AuthorRepository $authorRepository
     */
    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @param Request $request
     *
     * @return Author
     *
     * @throws \InvalidArgumentException
     */
    public function createFromRequest(Request $request)
    {
        try {
            $data = json_decode($request->getContent(), true);
            $this->validateCreateData($data);

            $author = $this->authorRepository->create(
                $data['name'],
                $data['description'],
                date_create_from_format("d/m/Y", $data['born'])
            );
            if (array_key_exists('died', $data)) {
                $author->setDied(date_create_from_format("d/m/Y", $data['died']));
            }
            $this->authorRepository->save($author);

            return $author;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid request body. ' . $e->getMessage());
        }
    }

    /**
     * @param $data
     *
     * @throws \InvalidArgumentException
     */
    private function validateCreateData($data)
    {
        $validator = Validation::createValidator();

        $constraint = new Assert\Collection([
            'name' => [
                new Assert\Required(),
                new Assert\NotBlank()
            ],
            'description' => [
                new Assert\Required(),
                new Assert\NotBlank()
            ],
            'born' => [
                new Assert\Required(),
                new Assert\NotNull()
            ],
            'died' => new Assert\Optional([
                new Assert\NotNull()
            ]),
        ]);

        $violations = $validator->validate($data, $constraint);

        if ($violations->count() > 0) {
            throw new \InvalidArgumentException("Missing required parameters. Required: name, description, born. Optional: died.");
        }
    }
}
