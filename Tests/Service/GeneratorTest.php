<?php

declare(strict_types=1);

namespace Werkspot\Bundle\SitemapBundle\Tests\Service;

use Mockery;
use PHPUnit\Framework\TestCase;
use Werkspot\Bundle\SitemapBundle\Provider\ProviderInterface;
use Werkspot\Bundle\SitemapBundle\Service\Generator;
use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSection;

/**
 * @internal
 *
 * @small
 */
final class GeneratorTest extends TestCase
{
    private Generator $generator;

    protected function setUp(): void
    {
        $this->generator = new Generator();
    }

    /** @test */
    public function generate_index_with_empty_count(): void
    {
        $mockProvider = Mockery::mock(ProviderInterface::class);

        $mockProvider->shouldReceive('getNumberOfPages')->andReturn(0);
        $mockProvider->shouldReceive('getSectionName')->andReturn('mock-empty-section');

        $this->generator->addProvider($mockProvider);
        $index = $this->generator->generateIndex();

        self::assertEmpty($index->getSections());
    }

    /** @test */
    public function generate_index(): void
    {
        $mockCount = 1234;
        $mockSection = Mockery::mock(SitemapSection::class);
        $mockSection->shouldReceive('setPageCount')->with($mockCount);
        $mockProvider = Mockery::mock(ProviderInterface::class);

        $mockProvider->shouldReceive('getNumberOfPages')->andReturn($mockCount);
        $mockProvider->shouldReceive('getSectionName')->andReturn('mock-empty-section');
        $mockProvider->shouldReceive('getSection')->andReturn($mockSection);

        $this->generator->addProvider($mockProvider);
        $index = $this->generator->generateIndex();

        self::assertEquals([$mockSection], $index->getSections());
    }
}
