<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @param Category $category
     */
    public function save(Category $category): void
    {
        $this->_em->persist($category);
        $this->_em->flush();
    }

    /**
     * @param string $id
     *
     * @throws EntityNotFoundException
     */
    public function remove(string $id): void
    {
        $category = $this->find($id);
        if (empty($category)) {
            throw new EntityNotFoundException();
        }
        $this->_em->remove($category);
        $this->_em->flush();
    }

    private function create($name)
    {
        $category = new Category($name);
        $this->save($category);

        return $category;
    }

    /**
     * @param Request $request
     *
     * @return Category
     */
    public function createFromRequest(Request $request): Category
    {
        $data = $this->getValidatedData($request);
        return $this->create(
            $data['name']
        );
    }

    /**
     * @param Request $request
     * @param string $id
     *
     * @return Category
     *
     * @throws EntityNotFoundException
     * @throws \InvalidArgumentException
     */
    public function updateFromRequest(Request $request, string $id)
    {
        $category = $this->find($id);
        if (empty($category)) {
            throw new EntityNotFoundException();
        }

        $data = $this->getValidatedData($request);
        $category->setName($data['name']);
        $this->save($category);

        return $category;
    }

    private function getValidatedData(Request $request): array
    {
        try {
            $data = json_decode($request->getContent(), true);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid request body. ' . $e->getMessage());
        }
        if (!array_key_exists("name", $data)) {
            throw new \InvalidArgumentException("Missing required parameters. Required: name");
        }
        return $data;
    }
}
