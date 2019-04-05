<?php

namespace Werkspot\Bundle\SitemapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('werkspot_sitemap');
        $this->getRootNode($treeBuilder, 'werkspot_sitemap');

        return $treeBuilder;
    }

    /**
     * @param TreeBuilder $treeBuilder
     * @param string $name
     * @return NodeDefinition|ArrayNodeDefinition
     */
    private function getRootNode(TreeBuilder $treeBuilder, string $name)
    {
        // BC layer for symfony/config 4.1 and older
        return method_exists($treeBuilder, 'getRootNode') ? $treeBuilder->getRootNode() : $treeBuilder->root($name);
    }
}
