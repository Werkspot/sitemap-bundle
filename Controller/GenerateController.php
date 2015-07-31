<?php
namespace Werkspot\Bundle\SitemapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class GenerateController extends Controller
{
    /**
     * Shows the sitemap index with links to deeper sitemap sections
     * @return Response
     */
    public function indexAction()
    {
        $index = $this->get('werkspot.sitemap.generator')->generateIndex();

        return $this->render('WerkspotSitemapBundle::index.xml.twig', [
            'sitemap_index' => $index
        ], $this->getEmptyXmlResponse());
    }

    /**
     * Renders a single sitemap section
     * @param string $section
     * @param int $page
     * @return Response
     */
    public function sectionAction($section, $page)
    {
        $sitemapSectionPage = $this->get('werkspot.sitemap.generator')->generateSectionPage($section, $page);

        if ($sitemapSectionPage->getCount() === 0) {
            throw $this->createNotFoundException('Requested page is out of range');
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
        $ttl = $this->get('service_container')->getParameter('werkspot.sitemap.default_ttl');
        $response->setTtl($ttl);
        return $response;
    }
}
