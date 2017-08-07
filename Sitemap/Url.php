<?php
namespace Werkspot\Bundle\SitemapBundle\Sitemap;

use DateTime;

class Url
{
    const CHANGEFREQ_ALWAYS = 'always';
    const CHANGEFREQ_HOURLY = 'hourly';
    const CHANGEFREQ_DAILY = 'daily';
    const CHANGEFREQ_WEEKLY = 'weekly';
    const CHANGEFREQ_MONTHLY = 'monthly';
    const CHANGEFREQ_YEARLY = 'yearly';
    const CHANGEFREQ_NEVER = 'never';

    /**
     * Absolute url
     *
     * @var string
     */
    protected $loc;

    /**
     * @var DateTime|null
     */
    protected $lastmod;

    /**
     * @var string|null
     */
    protected $changefreq;

    /**
     * String in float format
     *
     * @var string|null
     */
    protected $priority;

    /**
     * @var AlternateLink[]
     */
    protected $alternateLinks;

    /**
     * Construct a new basic url
     *
     * @param string $loc - absolute url
     * @param DateTime|null $lastmod
     * @param string|null $changefreq
     * @param float|null $priority
     */
    public function __construct($loc, $changefreq = null, $priority = null, DateTime $lastmod = null)
    {
        $this->setLoc($loc);
        $this->setLastmod($lastmod);
        $this->setChangefreq($changefreq);

        if ($priority !== null) {
            $this->setPriority($priority);
        }
    }

    /**
     * @param string $loc
     */
    protected function setLoc($loc)
    {
        $this->loc = $loc;
    }

    /**
     * @return string
     */
    public function getLoc()
    {
        return $this->loc;
    }

    /**
     * @param DateTime|null $lastmod
     */
    protected function setLastmod(DateTime $lastmod = null)
    {
        $this->lastmod = $lastmod;
    }

    /**
     * @return DateTime|null
     */
    public function getLastmod()
    {
        return $this->lastmod;
    }

    /**
     * Define the change frequency of this entry
     *
     * @param string|null $changefreq - String or null value used for defining the change frequency
     */
    protected function setChangefreq($changefreq = null)
    {
        if (!in_array(
            $changefreq,
            [
                self::CHANGEFREQ_ALWAYS,
                self::CHANGEFREQ_HOURLY,
                self::CHANGEFREQ_DAILY,
                self::CHANGEFREQ_WEEKLY,
                self::CHANGEFREQ_MONTHLY,
                self::CHANGEFREQ_YEARLY,
                self::CHANGEFREQ_NEVER,
                null,
            ]
        )
        ) {
            throw new \RuntimeException(sprintf('The value "%s" is not supported by the option changefreq. See http://www.sitemaps.org/protocol.html#xmlTagDefinitions', $changefreq));
        }

        $this->changefreq = $changefreq;
    }

    /**
     * @return string|null
     */
    public function getChangefreq()
    {
        return $this->changefreq;
    }

    /**
     * Define the priority of this entry
     *
     * @param float $priority - Float or null value used for defining the priority
     */
    public function setPriority($priority)
    {
        if (is_numeric($priority) && $priority >= 0 && $priority <= 1) {
            $this->priority = sprintf('%01.1f', $priority);
        } else {
            throw new \RuntimeException(sprintf('The value "%s" is not supported by the option priority, it must be a numeric between 0.0 and 1.0. See http://www.sitemaps.org/protocol.html#xmlTagDefinitions', $priority));
        }
    }

    /**
     * @return string|null
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param AlternateLink $alternateLink
     */
    public function addAlternateLink(AlternateLink $alternateLink)
    {
        $this->alternateLinks[] = $alternateLink;
    }

    /**
     * @return AlternateLink[]
     */
    public function getAlternateLinks()
    {
        return $this->alternateLinks;
    }
}
