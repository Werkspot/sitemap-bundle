<?php
namespace Werkspot\Bundle\SitemapBundle\Sitemap;

class SitemapSectionPage
{
    /**
     * Official max is 50000.
     * We keep the limit on 10000 to avoid having too big files that take too long to load
     * and make sure we don't hit reach the 50MB limit.
     */
    const MAX_ITEMS_PER_PAGE = 10000;

    /**
     * @var Url[]
     */
    private $urls = [];

    /**
     * @param Url $url
     */
    public function addUrl(Url $url)
    {
        $this->urls[] = $url;
    }

    /**
     * @return array
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return count($this->urls);
    }
}
