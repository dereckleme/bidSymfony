<?php
/**
 * Created by PhpStorm.
 * User: dereck
 * Date: 09/06/16
 * Time: 22:18
 */

namespace LeilaoBundle\Service;
use AppBundle\Entity\LeilaoLances;
use AppBundle\Entity\Usuario;
use AppBundle\Service\UsuarioService;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Leilao;
use Monolog\Logger;

class LeilaoService
{
    CONST TEMPO_CONTAGEM_REGRESSIVA = 2; //MINUTOS

    /**
     * Doctrine Entity Manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    protected $logger;

    protected $usuarioService;

    /**
     * Construtor Service Container
     */
    public function __construct(EntityManager $em, Logger $logger, UsuarioService $usuarioService)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->usuarioService = $usuarioService;
    }

    public function getList($situation)
    {
        $passagens = $this->em->getRepository("AppBundle:Passagem")->findBySituation($situation);

        return $passagens;
    }

    public function darLance($leilaoId, Usuario $usuario)
    {
        $leilaoRepository = $this->em->getRepository('AppBundle:Leilao');
        $leilao = $leilaoRepository->find($leilaoId);
        $saldo = $usuario->getSaldoLances();
        $leilaoValorAtualUpdated = $leilao->getValorAtual(true) + 0.01;

        if (!$leilao) {
            throw new \Exception("Leilão não encontrado");
        }

        $leilao->setUsuario($usuario);
        $leilao->setValorAtual($leilaoValorAtualUpdated);
        $usuario->setSaldoLances($saldo - 1);
        //Cria lance
        $leilaoLance = new LeilaoLances();
        $leilaoLance->setLeilao($leilao);
        $leilaoLance->setUsuario($usuario);
        $leilaoLance->setValor($leilaoValorAtualUpdated);

        //Start Timer down
        $lances = count($leilao->getLances()) + 1;
        if ($lances >= $leilao->getQtdMinimaLances()) {
            $dataContagem = (new \DateTime());
            $dataContagem->add(new \DateInterval('PT'.$this::TEMPO_CONTAGEM_REGRESSIVA.'M'));
            $leilao->setTempoleilao($dataContagem);
        }

        $this->em->persist($leilaoLance);
        $this->em->persist($usuario);
        $this->em->persist($leilao);

        $this->em->flush();
    }

    public function liveInfo($listFull = false)
    {
        $leiloes = $this->em->getRepository("AppBundle:Leilao")->getListLeiloesAbertos();
        $live = array();

        foreach ($leiloes as $leilao) {
            $passagem = $this->em->getRepository("AppBundle:Passagem")->findOneByLeilao($leilao);
            $valorEconomia = $passagem->getValor(true) - $leilao->getValorAtual(true);
            $desconto = 100 - $passagem->getValor(true) / 100 * $leilao->getValorAtual(true);

            $live[$leilao->getId()] = array(
               "idLeilao" => $leilao->getId(),
               "timer"    => $leilao->getTempoleilao(),
               "valorAtual" => $leilao->getValorAtual(),
               "valorEconomia" => number_format($valorEconomia, 2, ',', '.'),
               "desconto" => floor($desconto),
               "usuarioAtual" => strtoupper($leilao->getUsuario()->getApelido())
            );

            foreach ($leilao->getLances() as $lance) {
                $live[$leilao->getId()]['lancesTotal'][] = array(
                    "idLance" => $lance->getId(),
                    "valor" => $lance->getValor(),
                    "usuarioNome" => strtoupper($lance->getUsuario()->getApelido())
                );

                arsort($live[$leilao->getId()]['lancesTotal']);
            }

            if (isset($live[$leilao->getId()]['lancesTotal'])) {
                $live[$leilao->getId()]['lancesTotal'] = array_values($live[$leilao->getId()]['lancesTotal']);

                foreach ($live[$leilao->getId()]['lancesTotal'] as $number => $lance) {
                    if ($number < 10) {
                        $live[$leilao->getId()]['lances'][] = $lance;
                    }
                }

                if (!$listFull) {
                    unset($live[$leilao->getId()]['lancesTotal']);
                }
            }
        }

        return $live;
    }

    public function getLeiloesAbertosVencidos()
    {
        $repository = $this->em->getRepository("AppBundle:Leilao");
        $leiloesVencidos = $repository->getLeiloesVencidos();

        return $leiloesVencidos;
    }

    public function fecharLeiloes(array $leiloes)
    {
        /**
         * @var $leilao Leilao
         */
        foreach ($leiloes as $leilao) {
            $leilao->setSituacao(Leilao::FECHADO);
            $this->logger->addDebug("Alterando status do leilão nesse momento #idLeilao{$leilao->getId()}");
            $this->em->flush($leilao);
            $this->usuarioService->sendEmailGanhador($leilao->getUsuario());
            $this->logger->addDebug("Enviado email para o usuário{$leilao->getUsuario()->getEmail()}");
        }
    }
}
