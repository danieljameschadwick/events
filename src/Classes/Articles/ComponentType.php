<?php

declare(strict_types=1);

namespace App\Classes\Articles;

class ComponentType
{
    public const HEADER = 'header';
    public const PARAGRAPH = 'paragraph';
    public const IMAGE = 'image';

    public const TEMPLATE_PATH = '/components/article/%s.html.twig';
}