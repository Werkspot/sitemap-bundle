<?php

declare(strict_types=1);

namespace Werkspot\Bundle\SitemapBundle\Service;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Werkspot\Bundle\SitemapBundle\Provider\ProviderInterface;
use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapIndex;
use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSectionPage;

class Generator
{
    /**
     * @var ProviderInterface[]
     */
    private array $providers = [];

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

        if ($provider === null) {
            throw new NotFoundHttpException('No provider found for the given sitemap section');
        }

        return $provider->getPage($page);
    }

    public function addProvider(ProviderInterface $provider): void
    {
        $this->providers[$provider->getSectionName()] = $provider;
    }

    private function getProvider(string $sectionName): ?ProviderInterface
    {
        return $this->providers[$sectionName] ?? null;
    }
}
