<?php

declare(strict_types=1);

namespace Werkspot\Bundle\SitemapBundle\Provider;

use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSectionPage;

/**
 * Base class for a sitemap provider that may only have one page
 */
abstract class AbstractSinglePageSitemapProvider extends AbstractSitemapProvider
{
    final public function getPage(int $pageNumber): SitemapSectionPage
    {
        if ($pageNumber > 1) {
            return new SitemapSectionPage();
        }

        return $this->getSinglePage();
    }

    abstract public function getSinglePage(): SitemapSectionPage;

    /**
     * Returning number of results just enough to indicate one page
     */
    final public function getCount(): int
    {
        return 1;
    }
}
