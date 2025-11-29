<?php

namespace App\D07Bundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class D07Extension extends Extension
{

    public function load(array $configs, ContainerBuilder $container): void
    {

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('d07.number', $config['number']);
        $container->setParameter('d07.enable', $config['enable']);


    }
}



?>