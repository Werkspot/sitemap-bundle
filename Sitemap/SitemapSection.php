<?php
namespace Werkspot\Bundle\SitemapBundle\Sitemap;

class SitemapSection
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $pageCount = 0;

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
