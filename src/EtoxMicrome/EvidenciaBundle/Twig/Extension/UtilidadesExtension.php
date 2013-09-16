<?php

namespace EtoxMicrome\EvidenciaBundle\Twig\Extension;

use Symfony\Bridge\Doctrine\RegistryInterface;
use EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidad;
use Twig_Extension;
use Twig_Filter_Method;

class UtilidadesExtension extends \Twig_Extension
{
    protected $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getFilters()
    {
        return array(
        'highlightEntities' => new \Twig_Filter_Method($this, 'highlightEntities'),
        );
    }

    public function highlightEntities($texto,$identificadorEvidencia)
    {
        //ld($texto);
        //ld($identificadorEvidencia);
        //A partir del $identificadorEvidencia obtenemos todas las entidades que forman parte de la relaci—n
        $em=$this->doctrine->getManager();
        $evidenciasEntidades = $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->findEvidenciasEntidadesOfIdEvidencia($identificadorEvidencia);
        //ld($evidenciasEntidades);
        foreach ($evidenciasEntidades as $evidenciaEntidad){
            $tipo = $evidenciaEntidad->getEntidad()->getTipo();
            $nombre=$evidenciaEntidad->getTextminingName();
            //sustituimos en el texto
            //ld($nombre);
            switch ($tipo) {
                case 'organismo':
                    $alert="entra en organismo";
                    //ld($alert);
                    //ld($texto);
                    //ld($nombre);
                    $texto = str_replace($nombre, '<mark class="organism">'.$nombre.'</mark>', $texto);
                    //ld($texto);
                    break;
                case 'enzima':
                    $alert="entra en enzima";
                    $texto = str_replace($nombre, '<mark class="enzyme">'.$nombre.'</mark>', $texto);
                    break;
                case 'compuesto':
                    $alert="entra en compuesto";
                    $texto = str_replace($nombre, '<mark class="compound">'.$nombre.'</mark>', $texto);
                    break;
            }
        }
        return ($texto);
    }

    public function getName()
    {
        return 'utilidades';
    }
}


?>