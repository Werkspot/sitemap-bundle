<?php

declare(strict_types=1);

namespace Werkspot\Bundle\SitemapBundle\Lib\Sitemap;

use DateTime;
use RuntimeException;

final class Url
{
    public const CHANGE_FREQ_ALWAYS = 'always';
    public const CHANGE_FREQ_HOURLY = 'hourly';
    public const CHANGE_FREQ_DAILY = 'daily';
    public const CHANGE_FREQ_WEEKLY = 'weekly';
    public const CHANGE_FREQ_MONTHLY = 'monthly';
    public const CHANGE_FREQ_YEARLY = 'yearly';
    public const CHANGE_FREQ_NEVER = 'never';

    private $knownChangeFrequencies = [
        self::CHANGE_FREQ_ALWAYS,
        self::CHANGE_FREQ_HOURLY,
        self::CHANGE_FREQ_DAILY,
        self::CHANGE_FREQ_WEEKLY,
        self::CHANGE_FREQ_MONTHLY,
        self::CHANGE_FREQ_YEARLY,
        self::CHANGE_FREQ_NEVER,
        null,
    ];

    /**
     * Absolute url
     *
     * @var string
     */
    private $location;

    /**
     * @var DateTime|null
     */
    private $lastModified;

    /**
     * @var string|null
     */
    private $changeFrequency;

    /**
     * String in float format
     *
     * @var string|null
     */
    private $priority;

    /**
     * @var AlternateLink[]
     */
    private $alternateLinks;

    public function __construct(
        string $location,
        string $changeFrequency = null,
        float $priority = null,
        DateTime $lastModified = null
    ) {
        $this->location = $location;
        $this->setChangeFrequency($changeFrequency);
        $this->setPriority($priority);
        $this->lastModified = $lastModified;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function setChangeFrequency(string $changeFrequency = null): void
    {
        if (!in_array($changeFrequency, $this->knownChangeFrequencies)) {
            $message = 'The value "%s" is not supported by the change frequency option. See http://www.sitemaps.org/protocol.html#xmlTagDefinitions';
            throw new RuntimeException(sprintf($message, $changeFrequency));
        }

        $this->changeFrequency = $changeFrequency;
    }

    public function getChangeFrequency(): ?string
    {
        return $this->changeFrequency;
    }

    public function setPriority(float $priority = null): void
    {
        if ($priority === null) {
            $this->priority = $priority;

            return;
        }
        if (is_numeric($priority) && $priority >= 0 && $priority <= 1) {
            $this->priority = sprintf('%01.1f', $priority);
        } else {
            $message = 'The value "%s" is not supported by the priority option, it must be a numeric value between 0.0 and 1.0. See http://www.sitemaps.org/protocol.html#xmlTagDefinitions';
            throw new RuntimeException(sprintf($message, $priority));
        }
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function getLastModified(): ?DateTime
    {
        return $this->lastModified;
    }

    public function setLastModified(?DateTime $lastModified): void
    {
        $this->lastModified = $lastModified;
    }

    /**
     * @return AlternateLink[]
     */
    public function getAlternateLinks(): array
    {
        return $this->alternateLinks;
    }

    public function setAlternateLinks(AlternateLink ...$alternateLinks): void
    {
        $this->alternateLinks = $alternateLinks;
    }

    public function addAlternateLink(AlternateLink $alternateLink): void
    {
        $this->alternateLinks[] = $alternateLink;
    }
}
