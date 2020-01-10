<?php

declare(strict_types=1);

namespace Werkspot\Bundle\SitemapBundle\Lib;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Werkspot\Bundle\SitemapBundle\Lib\Provider\ProviderInterface;
use Werkspot\Bundle\SitemapBundle\Lib\Sitemap\SitemapIndex;
use Werkspot\Bundle\SitemapBundle\Lib\Sitemap\SitemapSectionPage;

final class Generator implements GeneratorInterface
{
    /**
     * @var ProviderInterface[]
     */
    private $providers = [];

    public function __construct(ProviderInterface ...$providers)
    {
        $this->providers = $providers;
    }

    public function generateIndex(): SitemapIndex
    {
        $index = new SitemapIndex();

        foreach ($this->providers as $provider) {
            if ($provider->getNumberOfPages() > 0) {
                $section = $provider->getSection();
                $section->setPageCount($provider->getNumberOfPages());
                $index->addSection($section);
            }
        }

        return $index;
    }

    public function generateSectionPage(string $sectionName, int $page): SitemapSectionPage
    {
        $provider = $this->getProvider($sectionName);

        if (null === $provider) {
            throw new NotFoundHttpException('No provider found for the given sitemap section');
        }

        return $provider->getPage($page);
    }

    private function getProvider(string $sectionName): ?ProviderInterface
    {
        return isset($this->providers[$sectionName]) ? $this->providers[$sectionName] : null;
    }
}
