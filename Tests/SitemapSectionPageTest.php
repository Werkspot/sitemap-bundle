<?php
namespace Werkspot\Bundle\SitemapBundle\Tests;

use Mockery;
use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSectionPage;
use Werkspot\Bundle\SitemapBundle\Sitemap\Url;

class SitemapSectionPageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SitemapSectionPage
     */
    protected $page;

    protected function setUp()
    {
        $this->page = new SitemapSectionPage();
    }

    public function testGetUrls()
    {
        $mockUrl = Mockery::mock(Url::class);
        $this->assertEquals([], $this->page->getUrls());
        $this->page->addUrl($mockUrl);
        $this->assertEquals([$mockUrl], $this->page->getUrls());
    }

    public function testCountUrls()
    {
        $mockUrl = Mockery::mock(Url::class);
        $this->assertEquals(0, $this->page->getCount());
        $this->page->addUrl($mockUrl);
        $this->assertEquals(1, $this->page->getCount());
    }
}
