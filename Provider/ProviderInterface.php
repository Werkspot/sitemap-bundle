<?php

declare(strict_types=1);

namespace Werkspot\Bundle\SitemapBundle\Provider;

use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSection;
use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSectionPage;

interface ProviderInterface
{
    public function getSection(): SitemapSection;

    public function getSectionName(): string;

    public function getNumberOfPages(): int;

    public function getCount(): int;

    public function getPage(int $pageNumber): SitemapSectionPage;
}
