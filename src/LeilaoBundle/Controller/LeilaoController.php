<?php

namespace LeilaoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Leilao;

class LeilaoController extends Controller
{
    public function indexAction($situation)
    {
        $serviceLeilao = $this->get("leilao.Service");

        $leiloesAbertos = $serviceLeilao->getList(Leilao::ABERTO);
        $proximosLeiloes = $serviceLeilao->getList(Leilao::PROXIMOS);
        $fechadosLeiloes = $serviceLeilao->getList(Leilao::FECHADO);
        
        return $this->render('LeilaoBundle:leilao:index.html.twig', array(
            "leiloesAbertos" => $leiloesAbertos,
            "proximosLeiloes" => $proximosLeiloes,
            "fechadosLeiloes" => $fechadosLeiloes
        ));
    }

    public function darLanceAction($leilaoId)
    {
        $leilaoService = $this->get('leilao.service');
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('fos_user_registration_register');
        } else if ($user->getSaldoLances() == 0) {
            return $this->redirectToRoute('AppBundleUsuarioHome');
        }

        $leilaoService->darLance($leilaoId, $user);

        return $this->redirectToRoute('LeilaoBundle');
    }

    public function liveAction()
    {
        $response = new JsonResponse();
        $leilaoService = $this->get('leilao.service');
        $liveInfo = $leilaoService->liveInfo();
        $response->setData($liveInfo);

        return $response;
    }

    /**
     * Get a user from the Security Token Storage.
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     */
    protected function getUser()
    {
        if (!$this->container->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return;
        }

        return $user;
    }
}
