<?php

declare(strict_types=1);

namespace Werkspot\Bundle\SitemapBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Werkspot\Bundle\SitemapBundle\Lib\Generator;

final class GenerateController
{
    /**
     * @var Generator
     */
    private $generator;

    /**
     * @var Environment
     */
    private $templateEngine;

    /**
     * @var int
     */
    private $sharedMaxAge;

    public function __construct(Generator $generator, Environment $templateEngine, int $sharedMaxAge)
    {
        $this->generator = $generator;
        $this->templateEngine = $templateEngine;
        $this->sharedMaxAge = $sharedMaxAge;
    }

    /**
     * Shows the sitemap index with links to deeper sitemap sections
     */
    public function indexAction(): Response
    {
        $index = $this->generator->generateIndex();

        return $this->render('@index.xml.twig', ['sitemap_index' => $index]);
    }

    /**
     * Renders a single sitemap section
     */
    public function sectionAction(string $section, int $page): Response
    {
        $sitemapSectionPage = $this->generator->generateSectionPage($section, $page);

        if ($sitemapSectionPage->getCount() === 0) {
            return new Response('Requested page is out of range', Response::HTTP_NOT_FOUND);
        }

        return $this->render('WerkspotSitemapBundle::section.xml.twig',
            ['sitemap_section' => $sitemapSectionPage]
        );
    }

    private function render(string $template, array $context): Response
    {
        $response = new Response(
            $this->templateEngine->render($template, $context),
            Response::HTTP_OK,
            ['Content-type' => 'text/xml', 'X-Robots-Tag' => 'noindex']
        );
        $response->setSharedMaxAge($this->sharedMaxAge);

        return $response;
    }
}
