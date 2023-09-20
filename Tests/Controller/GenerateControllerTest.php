<?php

declare(strict_types=1);

namespace Werkspot\Bundle\SitemapBundle\Tests\Controller;

use Mockery;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Werkspot\Bundle\SitemapBundle\Service\Generator;
use Werkspot\Bundle\SitemapBundle\Sitemap\AlternateLink;
use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapIndex;
use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSection;
use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSectionPage;
use Werkspot\Bundle\SitemapBundle\Sitemap\Url;

/**
 * @internal
 *
 * @small
 */
final class GenerateControllerTest extends WebTestCase
{
    /** @test */
    public function index_action(): void
    {
        $client = self::createClient();
        $url = $client->getContainer()->get('router')->generate(
            'werkspot_sitemap_index',
            [],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        $mockPageCount = 20;

        $mockSection = Mockery::mock(SitemapSection::class);
        $mockSection->shouldReceive('getName')->andReturn('MockSection');
        $mockSection->shouldReceive('getPageCount')->andReturn($mockPageCount);

        $mockSections = [
            $mockSection,
        ];

        $mockSitemapIndex = Mockery::mock(SitemapIndex::class);
        $mockSitemapIndex->shouldReceive('getSections')->andReturn($mockSections);

        $mockGenerator = Mockery::mock(Generator::class);
        $mockGenerator->shouldReceive('generateIndex')->andReturn($mockSitemapIndex);

        $client->getContainer()->set('werkspot.sitemap.generator', $mockGenerator);
        $client->request('GET', $url);

        self::assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        self::assertEquals('noindex', $client->getResponse()->headers->get('X-Robots-Tag'));

        $xml = simplexml_load_string($client->getResponse()->getContent());

        self::assertCount($mockPageCount, $xml->sitemap);
        self::assertGreaterThan(0, $client->getResponse()->getTtl());
    }

    /** @test */
    public function section_action(): void
    {
        $mockPage = 20;
        $mockSectionName = 'test';
        $mockUrlCount = 123;

        $client = self::createClient();
        $url = $client->getContainer()->get('router')->generate(
            'werkspot_sitemap_section_page',
            [
                'section' => $mockSectionName,
                'page' => $mockPage,
            ],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        $mockUrls = [];

        for ($i = 1; $i <= $mockUrlCount; ++$i) {
            $mockUrl = Mockery::mock(Url::class);
            $mockUrl->shouldIgnoreMissing();
            $mockUrls[] = $mockUrl;
        }

        $mockSectionPage = Mockery::mock(SitemapSectionPage::class);
        $mockSectionPage->shouldReceive('getUrls')->andReturn($mockUrls);
        $mockSectionPage->shouldReceive('getCount')->andReturn($mockUrlCount);

        $mockGenerator = Mockery::mock(Generator::class);
        $mockGenerator->shouldReceive('generateSectionPage')->andReturn($mockSectionPage);

        $client->getContainer()->set('werkspot.sitemap.generator', $mockGenerator);
        $client->request('GET', $url);

        self::assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        self::assertEquals('noindex', $client->getResponse()->headers->get('X-Robots-Tag'));

        $xml = simplexml_load_string($client->getResponse()->getContent());

        self::assertCount($mockUrlCount, $xml->url);
        self::assertCount(0, $xml->url[0]->children('xhtml', true));
        self::assertGreaterThan(0, $client->getResponse()->getTtl());
        self::assertGreaterThan(0, $client->getResponse()->getMaxAge());
    }

    /** @test */
    public function section_action_with_alternate_links(): void
    {
        $mockPage = 1;
        $mockSectionName = 'test';
        $mockAlternateLinkCount = 12;

        $client = self::createClient();
        $url = $client->getContainer()->get('router')->generate(
            'werkspot_sitemap_section_page',
            [
                'section' => $mockSectionName,
                'page' => $mockPage,
            ],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        $mockUrl = Mockery::mock(Url::class);
        $mockUrl->shouldIgnoreMissing();

        $mockAlternateLinks = [];
        for ($i = 1; $i <= $mockAlternateLinkCount; ++$i) {
            $mockAlternateLink = Mockery::mock(AlternateLink::class);
            $mockAlternateLink->shouldIgnoreMissing();
            $mockAlternateLinks[] = $mockAlternateLink;
        }

        $mockUrls = [$mockUrl];

        $mockSectionPage = Mockery::mock(SitemapSectionPage::class);
        $mockSectionPage->shouldReceive('getUrls')->andReturn($mockUrls);
        $mockSectionPage->shouldReceive('getCount')->andReturn(1);
        $mockUrl->shouldReceive('getAlternateLinks')->andReturn($mockAlternateLinks);

        $mockGenerator = Mockery::mock(Generator::class);
        $mockGenerator->shouldReceive('generateSectionPage')->andReturn($mockSectionPage);

        $client->getContainer()->set('werkspot.sitemap.generator', $mockGenerator);
        $client->request('GET', $url);

        self::assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        self::assertEquals('noindex', $client->getResponse()->headers->get('X-Robots-Tag'));

        $xml = simplexml_load_string($client->getResponse()->getContent());

        self::assertCount($mockAlternateLinkCount, $xml->url[0]->children('xhtml', true));
        self::assertGreaterThan(0, $client->getResponse()->getTtl());
        self::assertGreaterThan(0, $client->getResponse()->getMaxAge());
    }

    /** @test */
    public function section_action_out_of_range(): void
    {
        $mockPage = 20;
        $mockSectionName = 'test';

        $client = self::createClient();
        $url = $client->getContainer()->get('router')->generate(
            'werkspot_sitemap_section_page',
            [
                'section' => $mockSectionName,
                'page' => $mockPage,
            ],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        $mockSectionPage = Mockery::mock(SitemapSectionPage::class);
        $mockSectionPage->shouldReceive('getCount')->andReturn(0);
        $mockSectionPage->shouldReceive('getUrls')->andReturn([]);

        $mockGenerator = Mockery::mock(Generator::class);
        $mockGenerator->shouldReceive('generateSectionPage')->andReturn($mockSectionPage);

        $client->getContainer()->set('werkspot.sitemap.generator', $mockGenerator);
        $client->request('GET', $url);

        self::assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $xml = simplexml_load_string($client->getResponse()->getContent());
        self::assertEquals('urlset', $xml->getName());
        self::assertSame(0, $xml->count());
    }
}
