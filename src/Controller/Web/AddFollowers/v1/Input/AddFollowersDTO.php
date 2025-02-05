<?php

namespace App\Controller\Web\AddFollowers\v1\Input;

class AddFollowersDTO
{
    public function __construct(
        public readonly int $authorId,
        public readonly string $followerLoginPrefix,
        public readonly int $count,
    ) {
    }
}
