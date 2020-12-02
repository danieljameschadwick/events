<?php

declare(strict_types=1);

namespace App\DTO\News;

use App\Entity\News\Article;
use App\Entity\User\User;

class ArticleDTO
{
    /**
     * @var string|null
     */
    private $title;

    /**
     * @var string|null
     */
    private $body;

    /**
     * @var User|null
     */
    private $author;

    /**
     * @var string|null
     */
    private $imagePath;

    /**
     * @var string|null
     */
    private $strapLine;

    /**
     * @var \DateTimeInterface|null
     */
    private $publishDate;

    /**
     * ArticleDTO constructor.
     *
     * @param string|null             $title
     * @param string|null             $body
     * @param User|null               $author
     * @param string|null             $imagePath
     * @param string|null             $strapLine
     * @param \DateTimeInterface|null $publishDate
     */
    public function __construct(
        ?string $title,
        ?string $body,
        ?User $author,
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
     * @param string|null             $title
     * @param string|null             $body
     * @param User|null               $author
     * @param string|null             $imagePath
     * @param string|null             $strapLine
     * @param \DateTimeInterface|null $publishDate
     *
     * @return self
     */
    public static function create(
        ?string $title,
        ?string $body,
        ?User $author,
        ?string $imagePath,
        ?string $strapLine,
        ?\DateTimeInterface $publishDate
    ): self {
        return new self(
            $title,
            $body,
            $author,
            $imagePath,
            $strapLine,
            $publishDate
        );
    }

    /**
     * @param Article $article
     *
     * @return ArticleDTO
     */
    public static function populate(Article $article): ArticleDTO
    {
        return new self(
            $article->getTitle(),
            $article->getBody(),
            $article->getAuthor(),
            $article->getImagePath(),
            $article->getStrapLine(),
            $article->getPublishDate()
        );
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string|null
     */
    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    /**
     * @param string $imagePath
     */
    public function setImagePath(string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    /**
     * @return string|null
     */
    public function getStrapLine(): ?string
    {
        return $this->strapLine;
    }

    /**
     * @param string $strapLine
     */
    public function setStrapLine(string $strapLine): void
    {
        $this->strapLine = $strapLine;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publishDate;
    }

    /**
     * @param \DateTimeInterface $publishDate
     */
    public function setPublishDate(\DateTimeInterface $publishDate): void
    {
        $this->publishDate = $publishDate;
    }
}
