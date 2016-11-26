<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Leilao;

class LeilaoRepository extends EntityRepository
{
    public function getListLeiloesAbertos()
    {
        $qb = $this->createQueryBuilder('leilao');
        $qb->where("leilao.datainicio < :now")
            ->andWhere("leilao.situacao IS NULL")
            ->setParameter('now', new \DateTime('now'));

        $result = $qb->getQuery()
            ->getResult();

        return $result;
    }

    public function getLeiloesVencidos()
    {
        $qb = $this->createQueryBuilder('leilao');
        $qb->where("leilao.tempoleilao < :now")
            ->andWhere("leilao.situacao IS NULL")
            ->setParameter('now', new \DateTime('now'));

        $result = $qb->getQuery()
            ->getResult();

        return $result;
    }
}