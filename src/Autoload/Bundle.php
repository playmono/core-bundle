<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Contao\Bundle\CoreBundle\Autoload;

/**
 * Handles a Contao autoload bundle
 *
 * @author Leo Feyer <https://contao.org>
 */
class Bundle implements BundleInterface
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $replace = [];

    /**
     * @var array
     */
    protected $environments = ['all'];

    /**
     * @var array
     */
    protected $loadAfter = [];

    /**
     * Constructor
     *
     * @param string $class   The class name
     * @param array  $options The bundle options
     */
    public function __construct($class, array $options)
    {
        $this->class = $class;
        $this->name  = $this->getBundleName($class);

        if (!empty($options['replace'])) {
            $this->setReplace($options['replace']);
        }

        if (!empty($options['environments'])) {
            $this->setEnvironments($options['environments']);
        }

        if (!empty($options['load-after'])) {
            $this->setLoadAfter($options['load-after']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritdoc}
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReplace()
    {
        return $this->replace;
    }

    /**
     * {@inheritdoc}
     */
    public function setReplace(array $replace)
    {
        $this->replace = $replace;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnvironments()
    {
        return $this->environments;
    }

    /**
     * {@inheritdoc}
     */
    public function setEnvironments(array $environments)
    {
        $this->environments = $environments;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLoadAfter()
    {
        return $this->loadAfter;
    }

    /**
     * {@inheritdoc}
     */
    public function setLoadAfter(array $loadAfter)
    {
        $this->loadAfter = $loadAfter;

        return $this;
    }

    /**
     * Get the bundle name from its class name
     *
     * @param string $class The class name
     *
     * @return string The bundle name
     */
    protected function getBundleName($class)
    {
        $chunks = explode('\\', $class);

        return array_pop($chunks);
    }
}