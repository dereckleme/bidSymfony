<?php
/**
 * Created by PhpStorm.
 * User: dereck
 * Date: 26/11/2016
 * Time: 02:10
 */

namespace AppBundle\Service;


use AppBundle\Entity\Usuario;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\DependencyInjection\Container;

class UsuarioService
{
    /**
     * @var ContainerAwareInterface
     */
    protected $container;


    /**
     * @var TwigEngine
     */
    protected $twigEngine;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * Construtor Service Container
     */
    public function __construct(Container $container, TwigEngine $twigEngine, \Swift_Mailer $mailer)
    {
        $this->twigEngine = $twigEngine;
        $this->mailer = $mailer;
        $this->container = $container;
    }

    public function sendEmailGanhador(Usuario $usuario)
    {
        $emailFrom = $this->container->getParameter('mailer_user');
        $message = \Swift_Message::newInstance()
            ->setSubject('Parabens você é o ganhador do leilão bidtravel')
            ->setFrom($emailFrom)
            ->setTo($usuario->getEmail())
            ->setBody(
                $this->twigEngine->render(":emails:ganhadorLeilao.html.twig", array("usuario" => $usuario)),
                'text/html'
            )
        ;
        $this->mailer->send($message);

    }
}