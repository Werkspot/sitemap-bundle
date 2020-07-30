<?php

declare(strict_types=1);

namespace Werkspot\Bundle\SitemapBundle\Provider;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSection;
use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSectionPage;

abstract class AbstractSitemapProvider implements ProviderInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    protected $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    final public function getNumberOfPages(): int
    {
        return ceil($this->getCount() / $this->getMaxItemsPerPage());
    }

    public function getSection(): SitemapSection
    {
        return new SitemapSection($this->getSectionName());
    }

    final protected function generateUrl(strintg $routeName, array $options = []): string
    {
        return $this->urlGenerator->generate($routeName, $options, UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * Just to get consistent paging even with smaller limits
     */
    protected function getSimpleArrayPage(array $data, int $page): array
    {
        $limit = $this->getMaxItemsPerPage();
        $offset = ($page - 1) * $limit;

        return array_slice($data, $offset, $limit);
    }

    protected function getMaxItemsPerPage(): int
    {
        return SitemapSectionPage::MAX_ITEMS_PER_PAGE;
    }
}
