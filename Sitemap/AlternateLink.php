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

    public function __construct(string $href, string $hreflang)
    {
        $this->href = $href;
        $this->hreflang = $hreflang;
    }

    public function getHref(): string
    {
        return $this->href;
    }

    public function getHreflang(): string
    {
        return $this->hreflang;
    }
}
