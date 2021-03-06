<?php

/*
 * This file is part of Contao.
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Contao\CoreBundle\DependencyInjection\Compiler;

use Contao\CoreBundle\HttpKernel\Bundle\ContaoModuleBundle;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Adds the bundle resources paths to the container.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class AddResourcesPathsPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $container->setParameter('contao.resources_paths', $this->getResourcesPath($container));
    }

    /**
     * Returns the Contao resources paths as array.
     *
     * @param ContainerBuilder $container
     *
     * @return array
     */
    private function getResourcesPath(ContainerBuilder $container)
    {
        $paths = [];
        $rootDir = $container->getParameter('kernel.project_dir');

        foreach ($container->getParameter('kernel.bundles') as $name => $class) {
            if (ContaoModuleBundle::class === $class) {
                $paths[] = sprintf('%s/system/modules/%s', $rootDir, $name);
            } elseif (null !== ($path = $this->getResourcesPathFromClassName($class))) {
                $paths[] = $path;
            }
        }

        if (is_dir($rootDir.'/app/Resources/contao')) {
            $paths[] = $rootDir.'/app/Resources/contao';
        }

        return $paths;
    }

    /**
     * Returns the resources path from the class name.
     *
     * @param string $class
     *
     * @return string|null
     */
    private function getResourcesPathFromClassName($class)
    {
        $reflection = new \ReflectionClass($class);

        if (is_dir($dir = dirname($reflection->getFileName()).'/Resources/contao')) {
            return $dir;
        }

        return null;
    }
}
