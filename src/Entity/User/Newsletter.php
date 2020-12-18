<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\DTO\NewsletterDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     schema="Users",
 *     name="tblNewsletter"
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\NewsletterRepository")
 */
class Newsletter
{
    /**
     * @var integer|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="intNewsletterId", type="integer", length=10, unique=true)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="strEmail", type="string", length=80, unique=true)
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="bolSubscribed", type="boolean")
     */
    private $subscribed;

    /**
     * @var User|null
     *
     * @ORM\OneToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(name="strUserUuid", referencedColumnName="strUuid", nullable=true)
     */
    private $user;

    /**
     * @param string $email
     * @param bool $subscribed
     * @param User $user
     */
    private function __construct(string $email, bool $subscribed = false, ?User $user = null)
    {
        $this->email = $email;
        $this->subscribed = $subscribed;
        $this->user = $user;
    }

    /**
     * @param string $email
     * @param bool $subscribed
     * @param User $user
     *
     * @return Newsletter
     */
    public static function create(
        string $email,
        bool $subscribed = false,
        ?User $user = null
    ): Newsletter
    {
        return new self(
            $email,
            $subscribed,
            $user
        );
    }

    /**
     * @param NewsletterDTO $newsletterDTO
     *
     * @return Newsletter
     */
    public static function createFromDTO(NewsletterDTO $newsletterDTO): self
    {
        return new self(
            $newsletterDTO->getEmail(),
            $newsletterDTO->isSubscribed(),
            $newsletterDTO->getUser()
        );
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return bool
     */
    public function isSubscribed(): bool
    {
        return $this->subscribed;
    }

    public function subscribe(): void
    {
        $this->subscribed = true;
    }

    public function unsubscribe(): void
    {
        $this->subscribed = false;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
}