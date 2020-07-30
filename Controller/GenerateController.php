<?php
namespace Werkspot\Bundle\SitemapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Werkspot\Bundle\SitemapBundle\Service\Generator;

final class GenerateController
{
    /**
     * @var int
     */
    private $cacheAge;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var Generator
     */
    private $sitemapGenerator;

    public function __construct(int $cacheAge, Generator $sitemapGenerator, Environment $twig)
    {
        $this->cacheAge = $cacheAge;
        $this->twig = $twig;
        $this->sitemapGenerator = $sitemapGenerator;
    }

    /**
     * Shows the sitemap index with links to deeper sitemap sections
     */
    public function indexAction(): Response
    {
        $index = $this->sitemapGenerator->generateIndex();

        return $this->render('@WerkspotSitemapBundle/index.xml.twig', [
            'sitemap_index' => $index
        ], $this->getEmptyXmlResponse());
    }

    /**
     * Renders a single sitemap section
     */
    public function sectionAction(string $section, int $page): Response
    {
        $sitemapSectionPage = $this->sitemapGenerator->generateSectionPage($section, $page);

        return $this->render('@WerkspotSitemapBundle/section.xml.twig', [
            'sitemap_section' => $sitemapSectionPage
        ], $this->getEmptyXmlResponse());
    }

    private function getEmptyXmlResponse(): Response
    {
        $response = new Response(null, Response::HTTP_OK, [
            'Content-type' => 'text/xml',
            'X-Robots-Tag' => 'noindex'
        ]);
        $response->setSharedMaxAge($this->cacheAge);

        return $response;
    }

    protected function render(string $view, array $parameters = [], Response $response = null): Response
    {
        $content = $this->twig->render($view, $parameters);

        if (null === $response) {
            $response = new Response();
        }

        $response->setContent($content);

        return $response;
    }
}
