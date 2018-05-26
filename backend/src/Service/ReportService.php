<?php

namespace App\Service;

use App\Entity\Report;
use App\Repository\BookRepository;
use App\Repository\ReportRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class ReportService
{
    /** @var ReportRepository */
    private $reportRepository;

    /** @var BookRepository */
    private $bookRepository;

    /** @var UserRepository */
    private $userRepository;

    public function __construct(
        ReportRepository $reportRepository,
        BookRepository $bookRepository,
        UserRepository $userRepository
    ) {
        $this->reportRepository = $reportRepository;
        $this->bookRepository = $bookRepository;
        $this->userRepository = $userRepository;
    }

    public function createFromRequest(Request $request): Report
    {
        $data = $this->validate($request);
        return $this->reportRepository->create(
            $data['user'],
            $data['book'],
            $data['reason'],
            new \DateTime()
        );
    }

    public function updateFromRequest(Request $request, int $id): void
    {
        $report = $this->reportRepository->findIfExists($id);
        $data = $this->validate($request);
        $report
            ->setUser($data['user'])
            ->setBook($data['book'])
            ->setReason($data['reason'])
            ->setAddedAt(new \DateTime());
        $this->reportRepository->save($report);
    }

    public function validate(Request $request)
    {
        try {
            $data = json_decode($request->getContent(), true);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid request body. ' . $e->getMessage());
        }
        if (!array_key_exists("id", $data)) {
            throw new \InvalidArgumentException("Missing required parameters. Required: id");
        }
        if (!array_key_exists("bookId", $data)) {
            throw new \InvalidArgumentException("Missing required parameters. Required: bookId");
        }
        $data['book'] = $this->bookRepository->findIfExists($data['bookId']);

        if (!array_key_exists("userId", $data)) {
            throw new \InvalidArgumentException("Missing required parameters. Required: userId");
        }
        $data['user'] = $this->userRepository->findIfExists($data['userId']);
        return $data;
    }

    public function remove(int $id)
    {
        $this->reportRepository->remove($id);
    }

    public function getAll()
    {
        $this->reportRepository->findAll();
    }
}