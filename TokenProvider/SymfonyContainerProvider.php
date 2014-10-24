<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Symfony\Cmf\Component\RoutingAuto\TokenProvider;

use Symfony\Cmf\Component\RoutingAuto\TokenProviderInterface;
use Symfony\Cmf\Component\RoutingAuto\UriContext;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provide values parameters from a Symfony DI container
 */
class SymfonyContainerProvider implements TokenProviderInterface
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function provideValue(UriContext $uriContext, $options)
    {
        $parameterName = $options['parameter'];
        $value = $this->container->getParameter($parameterName);

        return $value;
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolverInterface $optionsResolver)
    {
        $optionsResolver->setRequired(array(
            'parameter'
        ));
    }
}
