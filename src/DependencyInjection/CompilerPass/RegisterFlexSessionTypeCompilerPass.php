<?php

namespace FlexSessionBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;
use FlexSession\FlexSessionHandlerFactory;

/**
 * Class RegisterFlexSessionTypeCompilerPass
 * @author Aleksandr Arofikin <sashaaro@gmail.com>
 */
class RegisterFlexSessionTypeCompilerPass implements CompilerPassInterface
{
    const FLEX_SESSION_TYPE_TEG = 'flex_session_type';

    public function process(ContainerBuilder $container)
    {
        foreach($container->findTaggedServiceIds(self::FLEX_SESSION_TYPE_TEG) as $serviceId => $tags) {
            if (!array_key_exists(0, $tags) || !array_key_exists('type', $tags[0]) || !$tags[0]['type']) {
                throw new InvalidArgumentException(sprintf('No specify type for %s tag', self::FLEX_SESSION_TYPE_TEG));
            }
            $container->getDefinition(FlexSessionHandlerFactory::class)
                ->addMethodCall('addType', [$tags[0]['type'], new Reference($serviceId)]);
        }
    }
}