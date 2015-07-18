<?php

namespace coolfarmer\MailingConnectorBundle;

use coolfarmer\MailingConnectorBundle\DependencyInjection\Compiler\MailingConnectorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class MailingConnectorBundle
 *
 * @package coolfarmer\MailingConnectorBundle
 */
class MailingConnectorBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MailingConnectorPass());
    }
}
