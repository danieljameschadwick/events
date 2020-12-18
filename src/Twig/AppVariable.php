<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\User\User;
use App\Interfaces\DoctrineAwareInterface;
use App\Traits\EntityManagerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\AppVariable as BaseAppVariable;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AppVariable extends BaseAppVariable implements DoctrineAwareInterface
{
    use EntityManagerTrait;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * AppVariable constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        EntityManagerInterface $entityManager
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->setManager($entityManager);
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        if (null === $tokenStorage = $this->tokenStorage) {
            throw new \RuntimeException('The "app.user" variable is not available.');
        }

        if (!$token = $tokenStorage->getToken()) {
            return null;
        }

        $user = $token->getUser();

        if (!$user instanceof User) {
            return null;
        }

        return $this->getManager()
            ->getRepository(User::class)
            ->getOneByUuid($user->getUuidString());
    }
}