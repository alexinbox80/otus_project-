<?php

namespace App\Controller\Web\DeleteUser\v1;

use App\Domain\Entity\User;
use App\Domain\Service\UserService;
use App\Application\Security\Voter\UserVoter;
use App\Controller\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class Manager
{
    public function __construct(
        private readonly UserService $userService,
        private readonly AuthorizationCheckerInterface $authorizationChecker
    )
    {
    }

    public function deleteUserById(int $userId): bool
    {
        return $this->userService->removeById($userId);
    }

    public function deleteUser(User $user): void
    {
        if (!$this->authorizationChecker->isGranted(UserVoter::DELETE, $user)) {
            throw new AccessDeniedException();
        }

        $this->userService->remove($user);
    }
}
