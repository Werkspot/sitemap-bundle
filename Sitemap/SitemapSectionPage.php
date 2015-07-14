<?php
namespace Werkspot\Bundle\SitemapBundle\Sitemap;

class SitemapSectionPage
{
    /**
     * Official max is 50000
     * We can keep it slightly lower to make sure we don't hit reach the 50MB limit instead
     */
    const MAX_ITEMS_PER_PAGE = 25000;

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
