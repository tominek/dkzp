<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /** @var CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/category", name="category_create", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        try {
            $this->categoryRepository->createFromRequest($request);
        } catch (\InvalidArgumentException $e) {
            return $this->json(["message" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/category/{id}", name="category_update", methods={"PUT"})
     * @IsGranted("ROLE_ADMIN")
     *
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function updateAction(Request $request, string $id)
    {
        try {
            $this->categoryRepository->updateFromRequest($request, $id);
        } catch (EntityNotFoundException $e) {
            return $this->json([], Response::HTTP_NOT_FOUND);
        } catch (\InvalidArgumentException $e) {
            return $this->json(["message" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/category/{id}", name="category_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function deleteAction(string $id)
    {
        try {
            $this->categoryRepository->remove($id);
        } catch (EntityNotFoundException $e) {
            return $this->json([], Response::HTTP_NOT_FOUND);
        }

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
