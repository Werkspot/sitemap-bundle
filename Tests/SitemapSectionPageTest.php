<?php
namespace Werkspot\Bundle\SitemapBundle\Tests;

use Mockery;
use PHPUnit\Framework\TestCase;
use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSectionPage;
use Werkspot\Bundle\SitemapBundle\Sitemap\Url;

class SitemapSectionPageTest extends TestCase
{
    /**
     * @var SitemapSectionPage
     */
    protected $page;


    protected function setUp(): void
    {
        parent::setUp();

        $this->page = new SitemapSectionPage();
    }

    public function testGetUrls(): void
    {
        $mockUrl = Mockery::mock(Url::class);
        $this->assertEquals([], $this->page->getUrls());
        $this->page->addUrl($mockUrl);
        $this->assertEquals([$mockUrl], $this->page->getUrls());
    }

    public function testCountUrls(): void
    {
        $mockUrl = Mockery::mock(Url::class);
        $this->assertEquals(0, $this->page->getCount());
        $this->page->addUrl($mockUrl);
        $this->assertEquals(1, $this->page->getCount());
    }
}
