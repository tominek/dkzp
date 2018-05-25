<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /** @var CategoryRepository */
    private $categoryRepository;

    /** @var EntityManager */
    private $entityManager;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/categories", name="categories", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function createAction(Request $request)
    {
        $this->entityManager = $this->getDoctrine()->getManager();

        $name = $request->request->get('name');
        if (!$name) {
            return $this->json([], Response::HTTP_BAD_REQUEST);
        }
        if ($this->categoryRepository->findBy(['name' => $name])) {
            return $this->json([], Response::HTTP_IM_USED);
        }
        $this->entityManager->persist(new Category($name));
        $this->entityManager->flush();

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/category/update", name="category_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request)
    {
        $this->entityManager = $this->getDoctrine()->getManager();

        $id = $request->get('id');
        $name = $request->get('name');
        if (!$name || !$id) {
            return $this->json([], Response::HTTP_BAD_REQUEST);
        }
        if ($this->categoryRepository->findBy(['name' => $name])) {
            return $this->json([], Response::HTTP_IM_USED);
        }
        $category = $this->categoryRepository->find($id);
        if (!$category instanceof Category) {
            return $this->json([], Response::HTTP_NOT_FOUND);
        }
        $category->setName($name);
        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/category/delete", name="category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request)
    {
        $this->entityManager = $this->getDoctrine()->getManager();

        $id = $request->get('id');
        if (!$id) {
            return $this->json([], Response::HTTP_BAD_REQUEST);
        }
        $category = $this->categoryRepository->find($id);
        if (!$category instanceof Category) {
            return $this->json([], Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/category/list", name="category_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $data = $this->categoryRepository->findAll();

        return $this->json([
            'data' => $data,
        ], Response::HTTP_OK);
    }
}
