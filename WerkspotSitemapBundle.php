<?php

declare(strict_types=1);

namespace Werkspot\Bundle\SitemapBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Werkspot\Bundle\SitemapBundle\DependencyInjection\Compiler\ProviderCompilerPass;

class WerkspotSitemapBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new ProviderCompilerPass());
    }
}
