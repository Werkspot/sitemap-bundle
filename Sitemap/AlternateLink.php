<?php
namespace Werkspot\Bundle\SitemapBundle\Sitemap;

/**
 * Class for adding alternate language links to a Url
 * Google Guidelines: https://support.google.com/webmasters/answer/2620865?hl=en
 */
class AlternateLink
{
    /**
     * @var string
     */
    private $href;

    /**
     * @var string
     */
    private $hreflang;

    /**
     * @param string $href
     * @param string $hreflang
     */
    public function __construct($href, $hreflang)
    {
        $this->href = $href;
        $this->hreflang = $hreflang;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @return string
     */
    public function getHreflang()
    {
        return $this->hreflang;
    }
}
