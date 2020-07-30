<?php

declare(strict_types=1);

namespace Werkspot\Bundle\SitemapBundle\Tests;

use Mockery;
use PHPUnit\Framework\TestCase;
use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSectionPage;
use Werkspot\Bundle\SitemapBundle\Sitemap\Url;

/**
 * @internal
 *
 * @small
 */
final class SitemapSectionPageTest extends TestCase
{
    protected SitemapSectionPage $page;

    protected function setUp(): void
    {
        parent::setUp();

        $this->page = new SitemapSectionPage();
    }

    /**
     * @test
     */
    public function get_urls(): void
    {
        $mockUrl = Mockery::mock(Url::class);
        self::assertEquals([], $this->page->getUrls());
        $this->page->addUrl($mockUrl);
        self::assertEquals([$mockUrl], $this->page->getUrls());
    }

    /**
     * @test
     */
    public function count_urls(): void
    {
        $mockUrl = Mockery::mock(Url::class);
        self::assertEquals(0, $this->page->getCount());
        $this->page->addUrl($mockUrl);
        self::assertEquals(1, $this->page->getCount());
    }
}
