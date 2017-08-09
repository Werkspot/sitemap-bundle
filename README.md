# Werkspot sitemap bundle
Bundle for generating dynamic sitemap.xml content with support for multiple sections and pages per section.

[![Travis build status](https://travis-ci.org/Werkspot/sitemap-bundle.svg?branch=master)](https://travis-ci.org/Werkspot/sitemap-bundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Werkspot/sitemap-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Werkspot/sitemap-bundle/?branch=master)

### Install

`# composer require werkspot/sitemap-bundle`

#### Update your routing

```yaml
werkspot_sitemap:
    resource: "@WerkspotSitemapBundle/Resources/config/routing.yml"
    prefix:   /
```
That will make the bundle listen to `/sitemap.xml`, `/sitemap.{section}.xml` and `/sitemap.{section}.{page}.xml`

### Usage

The bundle generates a sitemap by looking for data providers.

A provider is a class that implements [ProviderInterface](Provider/ProviderInterface.php) and is tagged as `werkspot.sitemap_provider` in the service container.

The bundle's service will gather data from all providers and create a sitemap section for everyone of them.

Each section can generate one or more pages.

#### Single page provider

To facilitate sitemap creation for static lists things or pages that do not need to be created dynamically [AbstractSinglePageSitemapProvider](Provider/AbstractSinglePageSitemapProvider.php) can be extended. That will only require providing a section name and a SitemapSectionPage with Url objects.

##### Example

```php
namespace AppBundle\Sitemap;

use Werkspot\Bundle\SitemapBundle\Provider\AbstractSinglePageSitemapProvider;
use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSectionPage;
use Werkspot\Bundle\SitemapBundle\Sitemap\Url;

class StaticPageSitemapProvider extends AbstractSinglePageSitemapProvider
{
    /**
     * @return string
     */
    public function getSectionName()
    {
        return 'default';
    }

    /**
     * @return SitemapSectionPage
     */
    public function getSinglePage()
    {
        $page = new SitemapSectionPage();

        $urlRoute = $this->generateUrl('home');
        $page->addUrl(new Url($urlRoute, Url::CHANGEFREQ_WEEKLY, 1.0));

        $urlRoute = $this->generateUrl('some_page');
        $page->addUrl(new Url($urlRoute, Url::CHANGEFREQ_WEEKLY, 0.6));

        $urlRoute = $this->generateUrl('another_page');
        $page->addUrl(new Url($urlRoute, Url::CHANGEFREQ_WEEKLY, 0.6));
    
        return $page;
    }
}
```

This will generate `/sitemap.default.xml` with 3 pages and put a link to it in `/sitemap.xml`

#### Multiple page provider

A more complex provider can extend [AbstractSitemapProvider](Provider/AbstractSitemapProvider.php).
In that case the provider can select how many pages it wants to generate and what results to return in every page.

##### Example

The following will generate `/sitemap.products.xml` and if the count is too high it will split in multiple pages: `/sitemap.products.1.xml`, `/sitemap.products.2.xml` etc and put all the right links to these in `/sitemap.xml` for indexing to happen.

```php
namespace AppBundle\Sitemap;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Werkspot\Bundle\SitemapBundle\Provider\AbstractSitemapProvider;
use Werkspot\Bundle\SitemapBundle\Sitemap\SitemapSectionPage;
use Werkspot\Bundle\SitemapBundle\Sitemap\Url;
use AppBundle\Domain\Entity\Repository\ProductRepository;
use AppBundle\Domain\Entity\Product;

class ProductSitemapProvider extends AbstractSitemapProvider
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param ProductRepository $productRepository
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, ProductRepository $productRepository)
    {
        parent::__construct($urlGenerator);
        $this->productRepository = $productRepository;
    }

    /**
     * @param int $pageNumber
     * @return SitemapSectionPage
     */
    public function getPage($pageNumber)
    {
        $products = $this->productRepository->getProductsForSitemapPage(
            $pageNumber,
            $this->getMaxItemsPerPage()
        );

        $page = new SitemapSectionPage();
        foreach ($products as $product) {
            $urlRoute = $this->generateUrl('product_details', [
                'slug' => $product->getSlug()
            ]);
            $page->addUrl(new Url($urlRoute, Url::CHANGEFREQ_MONTHLY, 0.6));
        }
        return $page;
    }

    /**
     * @return string
     */
    public function getSectionName()
    {
        return 'products';
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->productRepository->getTotalCount();
    }
}
```

### Adding alternate language pages

To add links to translations for pages to the sitemap, you can use `AlternateLink` and add these to a Url.

Google Guidelines: https://support.google.com/webmasters/answer/2620865?hl=en

*Note: The alternate links should include the Url itself, see the second note in the link above*

#### Example

```php
    /**
     * @return SitemapSectionPage
     */
    public function getSinglePage()
    {
        $page = new SitemapSectionPage();

        $urlRoute = $this->generateUrl('home');
        $urlRouteDe = $this->generateUrl('home', ['_locale' => 'de']);
        $urlRouteFr = $this->generateUrl('home', ['_locale' => 'fr']);
        
        $sitemapUrl = new Url($urlRoute, Url::CHANGEFREQ_WEEKLY, 1.0);
        $sitemapUrl->addAlternateLink(new AlternateLink($urlRouteDe, 'de'));
        $sitemapUrl->addAlternateLink(new AlternateLink($urlRouteFr, 'fr'));
        $sitemapUrl->addAlternateLink(new AlternateLink($urlRoute, 'x-default')); // Country select page
        // Or
        $sitemapUrl->addAlternateLink(new AlternateLink($urlRoute, 'en')); 
        
        $page->addUrl($sitemapUrl);

        return $page;
    }
```
