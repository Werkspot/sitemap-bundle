<?php
namespace Werkspot\Bundle\SitemapBundle\Provider;

use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSectionPage;

/**
 * Base class for a sitemap provider that may only have one page
 */
abstract class AbstractSinglePageSitemapProvider extends AbstractSitemapProvider
{
    /**
     * @param int $pageNumber
     * @return SitemapSectionPage
     */
    final public function getPage($pageNumber)
    {
        if ($pageNumber > 1) {
            return new SitemapSectionPage();
        }

        return $this->getSinglePage();
    }

    /**
     * @return SitemapSectionPage
     */
    abstract public function getSinglePage();

    /**
     * Returning number of results just enough to indicate one page
     *
     * @return int
     */
    final public function getCount()
    {
        return 1;
    }
}
