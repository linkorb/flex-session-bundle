<?php

namespace FlexSessionBundle\DependencyInjection;

use FlexSession\FlexSessionHandler;
use FlexSession\FlexSessionHandlerFactory;
use FlexSession\Type\File\FileSessionHandlerFactory;
use FlexSession\Type\Memcached\MemcachedSessionHandlerFactory;
use FlexSession\Type\Pdo\PdoSessionHandlerFactory;
use FlexSession\TypeProvider\TypeProviderFactory;
use FlexSession\TypeProvider\TypeProviderInterface;
use FlexSessionBundle\DependencyInjection\CompilerPass\RegisterFlexSessionTypeCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * Class FlexSessionExtension
 * @author Aleksandr Arofikin <sashaaro@gmail.com>
 */
class FlexSessionExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $definition = new Definition(TypeProviderInterface::class);
        $definition->setFactory([TypeProviderFactory::class, 'fromEnv']);
        $definition->addArgument('FLEX_SESSION');
        $container->setDefinition(TypeProviderInterface::class, $definition);

        $definition = new Definition(FlexSessionHandlerFactory::class);
        $definition->setAutowired(true);
        $container->setDefinition(FlexSessionHandlerFactory::class, $definition);

        $definition = new Definition(FlexSessionHandler::class);
        $definition->setAutowired(true);

        $container->setDefinition(FlexSessionHandler::class, $definition);

        $this->registerDefaultTypes($container);
    }

    /**
     * Register flex auth types from
     * @param ContainerBuilder $container
     */
    private function registerDefaultTypes(ContainerBuilder $container) {
        /* file */
        $definition = new Definition(FileSessionHandlerFactory::class);
        $definition->setAutowired(true);
        $definition->addTag(RegisterFlexSessionTypeCompilerPass::FLEX_SESSION_TYPE_TEG, ['type' => FileSessionHandlerFactory::TYPE]);
        $container->setDefinition('flex_session.type.'.FileSessionHandlerFactory::TYPE, $definition);

        /* pdo */
        $definition = new Definition(PdoSessionHandlerFactory::class);
        $definition->setAutowired(true);
        $definition->addTag(RegisterFlexSessionTypeCompilerPass::FLEX_SESSION_TYPE_TEG, ['type' => PdoSessionHandlerFactory::TYPE]);
        $container->setDefinition('flex_session.type.'.PdoSessionHandlerFactory::TYPE, $definition);

        /* memcached */
        $definition = new Definition(MemcachedSessionHandlerFactory::class);
        $definition->setAutowired(true);
        $definition->addTag(RegisterFlexSessionTypeCompilerPass::FLEX_SESSION_TYPE_TEG, ['type' => MemcachedSessionHandlerFactory::TYPE]);
        $container->setDefinition('flex_session.type.'.MemcachedSessionHandlerFactory::TYPE, $definition);
    }
}