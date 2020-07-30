<?php

declare(strict_types=1);

namespace Werkspot\Bundle\SitemapBundle\Sitemap;

class SitemapSection
{
    private string $name;

    private int $pageCount = 0;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPageCount(): int
    {
        return $this->pageCount;
    }

    public function setPageCount(int $pageCount): void
    {
        $this->pageCount = $pageCount;
    }
}
