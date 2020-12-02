<?php

declare(strict_types=1);

namespace App\Classes\Formatter;

use App\Classes\Articles\ComponentType;
use EditorJS\EditorJS;
use EditorJS\EditorJSException;

class ArticleFormatter
{
    public static $configuration = [
        'tools' => [
            'header' => [
                'text' => [
                    'type' => 'string',
                ],
                'level' => [
                    'type' => 'integer',
                ],
            ],
            'paragraph' => [
                'text' => [
                    'type' => 'string',
                ],
            ],
            'image' => [
                'file' => [
                    'type' => 'array',
                    'data' => [
                        'url' => [
                            'type' => 'string',
                        ],
                    ],
                ],
                'caption' => 'string',
                'withBorder' => 'boolean',
                'stretched' => 'boolean',
                'withBackground' => 'boolean',
            ],
        ],
    ];

    /**
     * @param string $data
     *
     * @return array
     */
    public static function format(string $data): array
    {
        try {
            $editor = new EditorJS($data, json_encode(self::$configuration));

            return $editor->getBlocks();
        } catch (EditorJSException $exception) {
            throw new \InvalidArgumentException('EditorJS data not properly configured. '.$exception->getMessage());
        }
    }

    /**
     * @param array $blocks
     *
     * @return string
     */
    private static function createFromBlocks(array $blocks): string
    {
        $content = '';

        foreach ($blocks as $block) {
            switch ($block['type']) {
                case ComponentType::HEADER:
                case ComponentType::PARAGRAPH:
                    $content .= $block['data']['text'];
                    break;

                case ComponentType::IMAGE:
                    break;

                default:
                    throw new \InvalidArgumentException(sprintf('%s has not been implemented.', $block['type']));
            }
        }

        return $content;
    }
}
