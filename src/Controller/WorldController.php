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

//        $users = $this->userBuilderService->createUserWithFollower(
//            'J.R.R. Tolkien',
//            'Ivan Ivanov'
//        );

        //$user = $this->userService->create('J.R.R. Tolkien');

        //$users = $this->userService->findUsersByLogin('Ivan Ivanov');
        //$users = $this->userService->findUsersByLoginWithCriteria('J.R.R. Tolkien');

        //return $this->json(array_map(static fn(User $user) => $user->toArray(), $users));
        //return $this->json($user->toArray());


//        $user = $this->userService->updateUserLogin(1, 'My new user');
//        [$data, $code] = $user === null ? [null, Response::HTTP_NOT_FOUND] : [$user->toArray(), Response::HTTP_OK];
//
//        return $this->json($data, $code);

//        $users = $this->userService->findUsersByLoginWithQueryBuilder('Tolkien');
//
//        return $this->json(array_map(static fn(User $user) => $user->toArray(), $users));

//        /** @var User $user */
//        $user = $this->userService->updateUserLoginWithQueryBuilder(1, 'User is updated again');
//
//        return $this->json($user->toArray());

        /** @var User $user */
        $user = $this->userService->updateUserLoginWithDBALQueryBuilder(1, 'User is updated by DBAL');

        return $this->json($user->toArray());
    }
}
