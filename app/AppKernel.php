<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new RaulFraile\Bundle\LadybugBundle\RaulFraileLadybugBundle(),
            new Ideup\SimplePaginatorBundle\IdeupSimplePaginatorBundle(),
            new EtoxMicrome\OrigenBundle\OrigenBundle(),
            new EtoxMicrome\EvidenciaBundle\EvidenciaBundle(),
            new EtoxMicrome\EntidadBundle\EntidadBundle(),
            new EtoxMicrome\RelacionBundle\RelacionBundle(),
            new EtoxMicrome\DominioBundle\DominioBundle(),
            new EtoxMicrome\EvidenciaDominioBundle\EvidenciaDominioBundle(),
            new EtoxMicrome\EvidenciaEntidadBundle\EvidenciaEntidadBundle(),
            new EtoxMicrome\FrontendBundle\FrontendBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new EtoxMicrome\UserBundle\UserBundle(),
            new Genemu\Bundle\FormBundle\GenemuFormBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new EtoxMicrome\RelacionUsuarioBundle\RelacionUsuarioBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {

            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
