<?php

namespace FlexSessionBundle;

use FlexSessionBundle\DependencyInjection\CompilerPass\RegisterFlexSessionTypeCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class FlexSessionBundle
 * @author Aleksandr Arofikin <sashaaro@gmail.com>
 */
class FlexSessionBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterFlexSessionTypeCompilerPass());
    }
}