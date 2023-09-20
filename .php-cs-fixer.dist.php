<?php

declare(strict_types=1);

use Instapro\CodingStandard\Load;

return Load::configuration(
    PhpCsFixer\Finder::create()
        ->exclude('Files')
        ->in([
            __DIR__ . '/Controller',
            __DIR__ . '/DependencyInjection',
            __DIR__ . '/Provider',
            __DIR__ . '/Resources',
            __DIR__ . '/Service',
            __DIR__ . '/Sitemap',
            __DIR__ . '/Tests',
        ])
        ->name('*.php'),
);