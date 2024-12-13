<?php

namespace App\Controller;

use App\Domain\Entity\User;
use App\Domain\Service\UserBuilderService;
use App\Domain\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class WorldController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly UserBuilderService $userBuilderService
    )
    {
    }

    public function hello(): Response
    {
//        $user = $this->userBuilderService->createUserWithTweets(
//            'J.R.R. Tolkien',
//            ['The Hobbit', 'The Lord of the Rings']
//        );

        $users = $this->userBuilderService->createUserWithFollower(
            'J.R.R. Tolkien',
            'Ivan Ivanov'
        );

        //$users = $this->userService->findUsersByLogin('Ivan Ivanov');
        //$users = $this->userService->findUsersByLoginWithCriteria('J.R.R. Tolkien');

        return $this->json(array_map(static fn(User $user) => $user->toArray(), $users));
    }
}
