<?php

declare(strict_types=1);

namespace App\Entity\News;

use App\Classes\Formatter\ArticleFormatter;
use App\DTO\News\ArticleDTO;
use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     schema="Events",
 *     name="tblArticle"
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="intArticleId", type="integer", length=20)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="strTitle", type="string", length=40)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="strBody", type="string")
     */
    private $body;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strImagePath", type="string", nullable=true)
     */
    private $imagePath;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strStrapLine", type="string", length=40, nullable=true)
     */
    private $strapLine;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="dtmPublishDate", type="datetime", nullable=true)
     */
    private $publishDate;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(name="strAuthorUuid", referencedColumnName="strUuid")
     */
    private $author;

    /**
     * @param string $title
     * @param string $body
     * @param User $author
     * @param string|null $imagePath
     * @param string|null $strapLine
     * @param \DateTimeInterface|null $publishDate
     */
    private function __construct(
        string $title,
        string $body,
        User $author,
        ?string $imagePath,
        ?string $strapLine,
        ?\DateTimeInterface $publishDate
    ) {
        $this->title = $title;
        $this->body = $body;
        $this->author = $author;
        $this->imagePath = $imagePath;
        $this->strapLine = $strapLine;
        $this->publishDate = $publishDate;
    }

    /**
     * @param ArticleDTO $articleDTO
     *
     * @return Article
     */
    public static function create(ArticleDTO $articleDTO): self
    {
        return new self(
            $articleDTO->getTitle(),
            $articleDTO->getBody(),
            $articleDTO->getAuthor(),
            $articleDTO->getImagePath(),
            $articleDTO->getStrapLine(),
            $articleDTO->getPublishDate()
        );
    }

    /**
     * @param ArticleDTO $articleDTO
     */
    public function updateFromDTO(ArticleDTO $articleDTO): void
    {
        $this->title = $articleDTO->getTitle();
        $this->body = $articleDTO->getBody();
        $this->imagePath = $articleDTO->getImagePath();
        $this->strapLine = $articleDTO->getStrapLine();
        $this->publishDate = $articleDTO->getPublishDate();
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        $slugify = strtolower(
            str_replace(' ', '-', $this->getBody())
        );

        return preg_replace('/[^A-Za-z0-9\-]/', '', $slugify);

    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getBodyBlocks(): array
    {
        return ArticleFormatter::format($this->getBody());
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @return string|null
     */
    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    /**
     * @return string|null
     */
    public function getStrapLine(): ?string
    {
        return $this->strapLine;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getPublishDate(): \DateTimeInterface
    {
        return $this->publishDate;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return null !== $this->getPublishDate();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%s: %d', get_class($this), $this->getId());
    }
}
