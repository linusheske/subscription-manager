<?php

namespace App\Repository;

use App\Entity\User;
use App\Exception\DatabaseObjectNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByEmailOrThrowException(string $email): User
    {
        $user = $this->findOneBy(['email' => $email]);

        if (!($user instanceof User)) {
            throw new DatabaseObjectNotFoundException(
                sprintf(
                    'could not find user with email %s',
                    $email
                )
            );
        }

        return $user;
    }

}