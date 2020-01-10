<?php

declare(strict_types=1);

namespace Werkspot\Bundle\SitemapBundle\Lib;

use Werkspot\Bundle\SitemapBundle\Lib\Sitemap\SitemapIndex;
use Werkspot\Bundle\SitemapBundle\Lib\Sitemap\SitemapSectionPage;

interface GeneratorInterface
{
    public function generateIndex(): SitemapIndex;

    public function generateSectionPage(string $sectionName, int $page): SitemapSectionPage;
}
