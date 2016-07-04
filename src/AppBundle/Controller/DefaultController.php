<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    public function comoFuncionaAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/como_funciona.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    public function cuponsAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/cupons.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    public function socialAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/social.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    public function conhecaAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/conheca.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    public function politicaPrivacidadeAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/politica_privacidade.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    public function duvidasAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/duvidas.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    public function contatoAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/contato.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
}
