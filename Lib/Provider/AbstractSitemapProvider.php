<?php
namespace Werkspot\Bundle\SitemapBundle\Lib\Provider;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Werkspot\Bundle\SitemapBundle\Lib\Sitemap\SitemapSection;
use Werkspot\Bundle\SitemapBundle\Lib\Sitemap\SitemapSectionPage;

abstract class AbstractSitemapProvider implements ProviderInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    protected $urlGenerator;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function getSection(): SitemapSection
    {
        return new SitemapSection($this->getSectionName());
    }

    final public function getNumberOfPages(): int
    {
        return ceil($this->getCount() / $this->getMaxItemsPerPage());
    }

    final protected function generateUrl(string $routeName, array $options = []): string
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
