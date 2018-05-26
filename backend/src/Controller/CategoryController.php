<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
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
    public function createAction(Request $request): JsonResponse
    {
        try {
            $this->categoryRepository->createFromRequest($request);
        } catch (\InvalidArgumentException $e) {
            return $this->json([
                "error" => "invalid_request",
                "message" => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
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
    public function updateAction(Request $request, string $id): JsonResponse
    {
        try {
            $this->categoryRepository->updateFromRequest($request, $id);
        } catch (EntityNotFoundException $e) {
            return $this->json([], Response::HTTP_NOT_FOUND);
        } catch (\InvalidArgumentException $e) {
            return $this->json([
                "error" => "invalid_request",
                "message" => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
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
    public function deleteAction(string $id): JsonResponse
    {
        try {
            $this->categoryRepository->remove($id);
        } catch (EntityNotFoundException $e) {
            return $this->json([], Response::HTTP_NOT_FOUND);
        }

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/category", name="category_list", methods={"GET"})
     * @IsGranted("ROLE_USER")
     *
     * @return JsonResponse
     */
    public function listAction(): JsonResponse
    {
        $data = $this->categoryRepository->findAll();

        return $this->json($data, Response::HTTP_OK);
    }
}
