<?php

declare(strict_types=1);

namespace App\DTO\News;

use App\Entity\User;

class ArticleDTO
{
    /**
     * @var string|null
     */
    private $title;

    /**
     * @var string|null
     */
    private $text;

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
     * @param string|null             $text
     * @param User|null               $author
     * @param string|null             $imagePath
     * @param string|null             $strapLine
     * @param \DateTimeInterface|null $publishDate
     */
    public function __construct(
        ?string $title,
        ?string $text,
        ?User $author,
        ?string $imagePath,
        ?string $strapLine,
        ?\DateTimeInterface $publishDate
    ) {
        $this->title = $title;
        $this->text = $text;
        $this->author = $author;
        $this->imagePath = $imagePath;
        $this->strapLine = $strapLine;
        $this->publishDate = $publishDate;
    }

    /**
     * @param string|null             $title
     * @param string|null             $text
     * @param User|null               $author
     * @param string|null             $imagePath
     * @param string|null             $strapLine
     * @param \DateTimeInterface|null $publishDate
     *
     * @return self
     */
    public static function create(
        ?string $title,
        ?string $text,
        ?User $author,
        ?string $imagePath,
        ?string $strapLine,
        ?\DateTimeInterface $publishDate
    ): self {
        return new self(
            $title,
            $text,
            $author,
            $imagePath,
            $strapLine,
            $publishDate
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
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
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
