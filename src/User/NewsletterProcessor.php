<?php

declare(strict_types=1);

namespace App\User;

use App\DTO\NewsletterDTO;
use App\Entity\User\Newsletter;
use App\Entity\User\User;
use App\Interfaces\DoctrineAwareInterface;
use App\Traits\EntityManagerTrait;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Security;

class NewsletterProcessor implements DoctrineAwareInterface
{
    use EntityManagerTrait;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * @var User|null
     */
    private $user;

    /**
     * @var Newsletter|null
     */
    private $newsletter;

    /**
     * @var NewsletterDTO|null
     */
    private $newsletterDTO;

    /**
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     * @param FlashBagInterface $flashBag
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security,
        FlashBagInterface $flashBag
    )
    {
        $this->setManager($entityManager);
        $this->security = $security;
        $this->flashBag = $flashBag;
    }

    /**
     * @return NewsletterDTO
     *
     * @throws \InvalidArgumentException
     */
    public function getNewsletterDTO(): NewsletterDTO
    {
        if (!$this->newsletterDTO instanceof NewsletterDTO) {
            throw new \InvalidArgumentException('NewsletterDTO is not set.');
        }

        return $this->newsletterDTO;
    }

    /**
     * @param NewsletterDTO $newsletterDTO
     */
    public function setNewsletterDTO(NewsletterDTO $newsletterDTO): void
    {
        $this->newsletterDTO = $newsletterDTO;
    }

    /**
     * @return Newsletter|null
     *
     * @throws \InvalidArgumentException
     */
    public function getNewsletter(): ?Newsletter
    {
        if ($this->newsletter instanceof Newsletter) {
            return $this->newsletter;
        }

        $newsletterDTO = $this->getNewsletterDTO();

        $newsletter = $this->getManager()
            ->getRepository(Newsletter::class)
            ->getOneByEmail($newsletterDTO->getEmail());

        if (!$newsletter instanceof Newsletter) {
            try {
                $newsletter = $this->create();
            } catch (\DomainException $exception) {
                $this->flashBag->add('error', 'Must sign in to sign up to the newsletter.');

                return null;
            }
        }

        $this->setNewsletter($newsletter);

        return $this->newsletter;
    }

    /**
     * @param Newsletter $newsletter
     */
    public function setNewsletter(Newsletter $newsletter): void
    {
        $this->newsletter = $newsletter;
    }

    /**
     * @return User
     *
     * @throws \InvalidArgumentException
     */
    public function getUser(): User
    {
        if (!$this->user instanceof User) {
            throw new \InvalidArgumentException('User not set.');
        }

        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Newsletter
     *
     * @throws \DomainException User must be signed in.
     */
    private function create(): Newsletter
    {
        $newsletterDTO = $this->getNewsletterDTO();

        $user = $this->getManager()
            ->getRepository(User::class)
            ->getOneByEmail($newsletterDTO->getEmail());

        $authenticatedUser = $this->security->getUser();

        if (
            !$authenticatedUser instanceof User
            || !$user instanceof User
        ) {
            return Newsletter::createFromDTO($newsletterDTO);
        }

        if ($user->getEmail() !== $authenticatedUser->getEmail()) {
            throw new \DomainException('User must be signed in.');
        }

        $newsletterDTO->setUser($user);
        $this->setNewsletterDTO($newsletterDTO);

        return Newsletter::createFromDTO($newsletterDTO);
    }

    public function subscribe(): void
    {
        $newsletter = $this->getNewsletter();

        if (!$newsletter instanceof Newsletter) {
            return;
        }

        $newsletter->subscribe();

        if (!$newsletter->getId()) {
            $this->getManager()->persist($newsletter);
        }

        try {
            $this->getManager()->flush();
        } catch (UniqueConstraintViolationException $exception) {
            $this->flashBag->add('error', 'Email is already subscribed to the newsletter.');

            return;
        } catch (\Exception $exception) {
            $this->flashBag->add('error', 'There was an error subscribing. Please try again later, or contact dan.');

            return;
        }

        $this->flashBag->add(
            'success',
            sprintf(
                '%s is now signed up to receive emails.',
                $newsletter->getEmail()
            )
        );
    }

}
