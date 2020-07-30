<?php
namespace Werkspot\Bundle\SitemapBundle\Tests\Service;

use Mockery;
use PHPUnit\Framework\TestCase;
use Werkspot\Bundle\SitemapBundle\Provider\ProviderInterface;
use Werkspot\Bundle\SitemapBundle\Service\Generator;
use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSection;

class GeneratorTest extends TestCase
{
    /**
     * @var Generator
     */
    private $generator;

    protected function setUp(): void
    {
        $this->generator = new Generator;
    }

    public function testGenerateIndexWithEmptyCount(): void
    {
        $mockProvider = Mockery::mock(ProviderInterface::class);

        $mockProvider->shouldReceive('getNumberOfPages')->andReturn(0);
        $mockProvider->shouldReceive('getSectionName')->andReturn('mock-empty-section');

        $this->generator->addProvider($mockProvider);
        $index = $this->generator->generateIndex();

        $this->assertEmpty($index->getSections());
    }

    public function testGenerateIndex(): void
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

        $this->assertEquals([$mockSection], $index->getSections());
    }
}
