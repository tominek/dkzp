<?php

namespace App\Controller;

use App\Service\ReportService;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends Controller
{
    /** @var ReportService */
    private $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * @Route("/report", name="report_create", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        try {
            $this->reportService->createFromRequest($request);
        } catch (\InvalidArgumentException $e) {
            return $this->json([
                "error" => "invalid_request",
                "message" => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/report/{id}", name="report_update", methods={"PUT"})
     * @IsGranted("ROLE_ADMIN")
     *
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function updateAction(Request $request, int $id)
    {
        try {
            $this->reportService->updateFromRequest($request, $id);
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
     * @Route("/report/{id}", name="report_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function deleteAction(string $id)
    {
        try {
            $this->reportService->remove($id);
        } catch (EntityNotFoundException $e) {
            return $this->json([], Response::HTTP_NOT_FOUND);
        }

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/report", name="report_list", methods={"GET"})
     *
     * @return Response
     */
    public function listAction(): Response
    {
        $data = $this->reportService->getAll();

        return $this->json([
            'data' => $data,
        ], Response::HTTP_OK);
    }
}
