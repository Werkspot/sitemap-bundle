<?php
namespace Werkspot\Bundle\SitemapBundle\Lib\Provider;

use Werkspot\Bundle\SitemapBundle\Lib\Sitemap\SitemapSection;
use Werkspot\Bundle\SitemapBundle\Lib\Sitemap\SitemapSectionPage;

interface ProviderInterface
{
    public function getSection(): SitemapSection;

    public function getSectionName(): string;

    public function getNumberOfPages(): int;

    public function getCount(): int;

    public function getPage(int $pageNumber): SitemapSectionPage;
}
