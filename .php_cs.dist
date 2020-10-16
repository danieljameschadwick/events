<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('var')
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_superfluous_phpdoc_tags' => false,
        'phpdoc_no_empty_return' => false,
        'phpdoc_add_missing_param_annotation' => [
            'only_untyped' => false,
        ],
    ])
    ->setFinder($finder)
;
