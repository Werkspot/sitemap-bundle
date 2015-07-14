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

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }

    /**
     * @param int $pageCount
     */
    public function setPageCount($pageCount)
    {
        $this->pageCount = $pageCount;
    }
}
