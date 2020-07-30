<?php
namespace Werkspot\Bundle\SitemapBundle\Sitemap;

use DateTime;

class Url
{
    public const CHANGEFREQ_ALWAYS = 'always';
    public const CHANGEFREQ_HOURLY = 'hourly';
    public const CHANGEFREQ_DAILY = 'daily';
    public const CHANGEFREQ_WEEKLY = 'weekly';
    public const CHANGEFREQ_MONTHLY = 'monthly';
    public const CHANGEFREQ_YEARLY = 'yearly';
    public const CHANGEFREQ_NEVER = 'never';

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

    public function __construct(string $loc, ?string $changefreq = null, ?float $priority = null, ?DateTime $lastmod = null)
    {
        $this->setLoc($loc);
        $this->setLastmod($lastmod);
        $this->setChangefreq($changefreq);

        if ($priority !== null) {
            $this->setPriority($priority);
        }
    }

    protected function setLoc(string $loc): void
    {
        $this->loc = $loc;
    }

    public function getLoc(): string
    {
        return $this->loc;
    }

    protected function setLastmod(DateTime $lastmod = null): void
    {
        $this->lastmod = $lastmod;
    }

    public function getLastmod(): ?DateTime
    {
        return $this->lastmod;
    }

    protected function setChangefreq(string $changefreq = null): void
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

    public function getChangefreq(): ?string
    {
        return $this->changefreq;
    }

    public function setPriority(float $priority)
    {
        if ($priority >= 0 && $priority <= 1) {
            $this->priority = sprintf('%01.1f', $priority);
        } else {
            throw new \RuntimeException(sprintf('The value "%s" is not supported by the option priority, it must be a numeric between 0.0 and 1.0. See http://www.sitemaps.org/protocol.html#xmlTagDefinitions', $priority));
        }
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function addAlternateLink(AlternateLink $alternateLink): void
    {
        $this->alternateLinks[] = $alternateLink;
    }

    /**
     * @return AlternateLink[]
     */
    public function getAlternateLinks(): array
    {
        return $this->alternateLinks;
    }
}
