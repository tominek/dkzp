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
     * @param string $id
     *
     * @return Category
     *
     * @throws EntityNotFoundException
     */
    public function findIfExists(string $id): Category
    {
        $cate = $this->find($id);
        if (empty($cate)) {
            throw new EntityNotFoundException('Category not found.');
        }
        return $cate;
    }

    /**
     * @param Category $category
     * @param bool $flush
     */
    public function save(Category $category, bool $flush = true): void
    {
        $this->_em->persist($category);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws EntityNotFoundException
     */
    public function remove(int $id): void
    {
        $category = $this->findIfExists($id);
        $this->_em->remove($category);
        $this->_em->flush();
    }

    private function create(string $name, string $description): Category
    {
        $category = new Category($name, $description);
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
            $data['name'],
            $data['desctiption']
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
        $category = $this->findIfExists($id);
        $data = $this->getValidatedData($request);
        $category->setName($data['name']);
        $category->setDescription($data['description']);
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
        if (!array_key_exists("description", $data)) {
            throw new \InvalidArgumentException("Missing required parameters. Required: description");
        }
        return $data;
    }
}
