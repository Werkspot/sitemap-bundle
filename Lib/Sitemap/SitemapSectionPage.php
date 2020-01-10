<?php

declare(strict_types=1);

namespace Werkspot\Bundle\SitemapBundle\Lib\Sitemap;

final class SitemapSectionPage
{
    /**
     * Official max is 50000.
     * We keep the limit on 10000 to avoid having too big files that take too long to load
     * and make sure we don't hit reach the 50MB limit.
     */
    public const MAX_ITEMS_PER_PAGE = 10000;

    /**
     * @var Url[]
     */
    private $urls = [];

    public function addUrl(Url $url): void
    {
        $this->urls[] = $url;
    }

    /**
     * @return Url[]
     */
    public function getUrls(): array
    {
        return $this->urls;
    }

    public function getCount(): int
    {
        return count($this->urls);
    }
}
