<?php

namespace App\D07Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    private bool $debug;

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('d07');

        $treeBuilder->getRootNode()
            ->children()
                ->integerNode('number')->isRequired()->end()
                ->booleanNode('enable')->defaultValue(true)->end()
            ->end()
        ;

        return $treeBuilder;
    }
}




?>