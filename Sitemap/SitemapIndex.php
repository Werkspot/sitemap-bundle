<?php

declare(strict_types=1);

namespace Werkspot\Bundle\SitemapBundle\Sitemap;

class SitemapIndex
{
    /**
     * @var SitemapSection
     */
    private array $sections = [];

    public function addSection(SitemapSection $section): void
    {
        $this->sections[] = $section;
    }

    /**
     * @return SitemapSection[]
     */
    public function getSections(): array
    {
        return $this->sections;
    }
}
