<?php
namespace Werkspot\Bundle\SitemapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Werkspot\Bundle\SitemapBundle\Service\Generator;

class GenerateController extends Controller
{
    /**
     * Shows the sitemap index with links to deeper sitemap sections
     *
     * @return Response
     */
    public function indexAction()
    {
        $index = $this->getSitemapGenerator()->generateIndex();

        return $this->render('WerkspotSitemapBundle::index.xml.twig', [
            'sitemap_index' => $index
        ], $this->getEmptyXmlResponse());
    }

    /**
     * Renders a single sitemap section
     * @param string $section
     * @param int $page
     *
     * @return Response
     */
    public function sectionAction($section, $page)
    {
        $sitemapSectionPage = $this->getSitemapGenerator()->generateSectionPage($section, $page);

        if ($sitemapSectionPage->getCount() === 0) {
            return new Response('Requested page is out of range', Response::HTTP_NOT_FOUND);
        }

        return $this->render('WerkspotSitemapBundle::section.xml.twig', [
            'sitemap_section' => $sitemapSectionPage
        ], $this->getEmptyXmlResponse());
    }

    /**
     * @return Response
     */
    private function getEmptyXmlResponse()
    {
        $response = new Response(null, Response::HTTP_OK, [
            'Content-type' => 'text/xml',
            'X-Robots-Tag' => 'noindex'
        ]);
        $sharedMaxAge = $this->getServiceContainer()->getParameter('werkspot.sitemap.cache.shared_max_age');
        $response->setSharedMaxAge($sharedMaxAge);

        return $response;
    }

    /**
     * @return Generator
     */
    private function getSitemapGenerator()
    {
        return $this->get('werkspot.sitemap.generator');
    }

    /**
     * @return ContainerInterface
     */
    private function getServiceContainer()
    {
        return $this->get('service_container');
    }
}
