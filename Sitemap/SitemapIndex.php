<?php
namespace Werkspot\Bundle\SitemapBundle\Sitemap;

class SitemapIndex
{
    /**
     * @var SitemapSection
     */
    private $sections;

    /**
     * @param SitemapSection $section
     */
    public function addSection(SitemapSection $section)
    {
        $this->sections[] = $section;
    }

    /**
     * @return SitemapSection[]
     */
    public function getSections()
    {
        return $this->sections;
    }
}
