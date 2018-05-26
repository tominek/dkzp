<?php

namespace App\Service;

use App\Entity\Forum;
use App\Entity\Report;
use App\Repository\ForumRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class ForumService
{
    /** @var ForumRepository */
    private $forumRepository;

    /** @var UserRepository */
    private $userRepository;

    public function __construct(ForumRepository $forumRepository, UserRepository $userRepository)
    {
        $this->forumRepository = $forumRepository;
        $this->userRepository = $userRepository;
    }

    public function createFromRequest(Request $request): Forum
    {
        $data = $this->validate($request);
        return $this->forumRepository->create(
            $data['subject'],
            $data['post'],
            $data['user'],
            new \DateTime(),
            $data['type']
        );
    }

    public function updateFromRequest(Request $request, int $id): void
    {
        $report = $this->forumRepository->findIfExists($id);
        $data = $this->validate($request);
        $report
            ->setSubject($data['subject'])
            ->setPost($data['post'])
            ->setUser($data['user'])
            ->setCreatedAt(new \DateTime())
            ->setType($data['type']);
        $this->forumRepository->save($report);
    }

    public function validate(Request $request)
    {
        try {
            $data = json_decode($request->getContent(), true);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid request body. ' . $e->getMessage());
        }
        if (!array_key_exists("subject", $data)) {
            throw new \InvalidArgumentException("Missing required parameters. Required: subject");
        }
        if (!array_key_exists("post", $data)) {
            throw new \InvalidArgumentException("Missing required parameters. Required: post");
        }
        if (!array_key_exists("userId", $data)) {
            throw new \InvalidArgumentException("Missing required parameters. Required: userId");
        }
        $data['user'] = $this->userRepository->findIfExists($data['userId']);

        if (!array_key_exists("type", $data)) {
            throw new \InvalidArgumentException("Missing required parameters. Required: type");
        }
        return $data;
    }

    public function remove(int $id)
    {
        $this->forumRepository->remove($id);
    }

    public function getAll()
    {
        return $this->forumRepository->findAll();
    }
}