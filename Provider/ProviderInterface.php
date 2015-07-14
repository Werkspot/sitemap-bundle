<?php
namespace Werkspot\Bundle\SitemapBundle\Provider;

use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSection;
use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSectionPage;

interface ProviderInterface
{
    /**
     * @return SitemapSection
     */
    public function getSection();

    /**
     * @return string
     */
    public function getSectionName();

    /**
     * @return int
     */
    public function getNumberOfPages();

    /**
     * @return int
     */
    public function getCount();

    /**
     * @param int $pageNumber
     * @return SitemapSectionPage
     */
    public function getPage($pageNumber);
}
