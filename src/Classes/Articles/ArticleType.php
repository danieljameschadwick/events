<?php

declare(strict_types=1);

namespace App\Classes\Articles;

class ArticleType
{
    public const HEADER = 'header';
    public const PARAGRAPH = 'paragraph';

    public const TEMPLATE_PATH = '/components/article/%s.html.twig';
}