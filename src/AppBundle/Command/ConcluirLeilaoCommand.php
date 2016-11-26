<?php
/**
 * Created by PhpStorm.
 * User: dereck
 * Date: 24/11/2016
 * Time: 23:28
 */

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ConcluirLeilaoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:concluir-leilao')

            // the short description shown while running "php bin/console list"
            ->setDescription('Monitora leilao e conclui o leilao.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $service = $container->get('leilao.service');

        $leiloesVencidos = $service->getLeiloesAbertosVencidos();
        $output->writeln(sprintf("Total de leilões vencidos %s", count($leiloesVencidos)));
        $service->fecharLeiloes($leiloesVencidos);
    }
}