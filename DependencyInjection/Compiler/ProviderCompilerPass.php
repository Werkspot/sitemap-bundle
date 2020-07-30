<?php

declare(strict_types=1);

namespace Werkspot\Bundle\SitemapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ProviderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('werkspot.sitemap.generator')) {
            return;
        }

        $definition = $container->findDefinition('werkspot.sitemap.generator');

        $taggedServices = $container->findTaggedServiceIds('werkspot.sitemap_provider');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addProvider', [new Reference($id)]);
        }
    }
}
