<?php
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
    private $providers = [];

    /**
     * @return SitemapIndex
     */
    public function generateIndex()
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

    /**
     * @param string $sectionName
     * @param int $page
     * @return SitemapSectionPage
     */
    public function generateSectionPage($sectionName, $page)
    {
        $provider = $this->getProvider($sectionName);

        if (null === $provider) {
            throw new NotFoundHttpException('No provider found for the given sitemap section');
        }

        return $provider->getPage($page);
    }

    /**
     * @param ProviderInterface $provider
     */
    public function addProvider(ProviderInterface $provider)
    {
        $this->providers[$provider->getSectionName()] = $provider;
    }

    /**
     * @param string $sectionName
     * @return null|ProviderInterface
     */
    private function getProvider($sectionName)
    {
        return isset($this->providers[$sectionName]) ? $this->providers[$sectionName] : null;
    }
}
