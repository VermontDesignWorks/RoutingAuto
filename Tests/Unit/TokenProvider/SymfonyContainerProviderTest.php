<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Symfony\Cmf\Component\RoutingAuto\Tests\Unit\TokenProvider;

use Symfony\Cmf\Component\RoutingAuto\Tests\Unit\BaseTestCase;
use Symfony\Cmf\Component\RoutingAuto\TokenProvider\SymfonyContainerProvider;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SymfonyContainerProviderTest extends BaseTestCase
{
    private $uriContext;
    private $container;

    public function setUp()
    {
        parent::setUp();

        $this->uriContext = $this->prophesize('Symfony\Cmf\Component\RoutingAuto\UriContext');
        $this->container = $this->prophesize('Symfony\Component\DependencyInjection\ContainerInterface');
        $this->provider = new SymfonyContainerProvider($this->container->reveal());
    }

    public function provideParameterValue()
    {
        return array(
            array(array('parameter' => 'foobar'), null),
            array(array('foobar' => 'barfoo'), 'Symfony\Component\OptionsResolver\Exception\InvalidOptionsException'),
            array(array(), 'Symfony\Component\OptionsResolver\Exception\MissingOptionsException'),
        );
    }

    /**
     * @dataProvider provideParameterValue
     */
    public function testParameterValue($options, $expectedException)
    {
        if (null !== $expectedException) {
            $this->setExpectedException($expectedException);
        }

        $this->container->getParameter('foobar')->willReturn('barfoo');

        $optionsResolver = new OptionsResolver();
        $this->provider->configureOptions($optionsResolver);
        $options = $optionsResolver->resolve($options);

        $res = $this->provider->provideValue($this->uriContext->reveal(), $options);

        $this->assertEquals('barfoo', $res);
    }
}

