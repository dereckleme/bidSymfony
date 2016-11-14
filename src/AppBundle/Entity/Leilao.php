<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * Leilao
 *
 * @ORM\Table(name="leilao")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LeilaoRepository")
 */
class Leilao
{
    CONST FECHADO    = 'fechado';
    CONST PROXIMOS   = 'proximos';
    CONST ABERTO     = 'abertos';

    /**
     * @var integer
     *
     * @ORM\Column(name="idleilao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataInicio", type="datetime", nullable=true)
     */
    protected $datainicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tempoLeilao", type="datetime", nullable=true)
     */
    protected $tempoleilao;

    /**
     * @var string
     *
     * @ORM\Column(name="situacao", type="string", length=45, nullable=true)
     */
    protected $situacao;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $lances
     *
     * @ORM\OneToMany(targetEntity="LeilaoLances", mappedBy="leilao")
     */
    protected $lances;

    /**
     * @var integer
     *
     * @ORM\Column(name="qtdMinimaLances", type="integer", nullable=false)
     */
    protected $qtdMinimaLances;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="idusuario", nullable=true)
     * })
     */
    protected $usuario;

    /**
     * @ORM\Column(name="valor_atual", type="float", scale=2)
     */
    protected $valor_atual;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lances   = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $idleilao
     */
    public function setId($idleilao)
    {
        $this->id = $idleilao;
    }

    /**
     * @return \DateTime
     */
    public function getDatainicio()
    {
        return $this->datainicio;
    }

    /**
     * @param \DateTime $datainicio
     */
    public function setDatainicio($datainicio)
    {
        $this->datainicio = $datainicio;
    }

    /**
     * @return \DateTime
     */
    public function getTempoleilao()
    {
        $data_inicial = (new \DateTime());
        $data_final = $this->tempoleilao;

        if ($data_final == null) {
            return null;
        }

        $diferenca = $data_inicial->diff($data_final);

        if (!$diferenca->invert) {
            return $diferenca->format('%Hh%Im%Ss');
        } else {
            return null;
        }
    }

    /**
     * @param \DateTime $tempoleilao
     */
    public function setTempoleilao($tempoleilao)
    {
        $this->tempoleilao = $tempoleilao;
    }

    /**
     * @return string
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * @param string $situacao
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    }

    /**
     * @return ArrayCollection
     */
    public function getLances()
    {
        return $this->lances;
    }

    public function getLancesByLimit($limit)
    {
        $criteria = Criteria::create()
            ->orderBy(array('id'=> \Doctrine\Common\Collections\Criteria::DESC))
            ->setMaxResults($limit);

        if ($this->getLances()) {
            return $this->getLances()->matching($criteria);
        } else {
            return false;
        }

    }

    /**
     * @param ArrayCollection $lances
     */
    public function setLances($lances)
    {
        $this->lances = $lances;
    }

    public function leilaoEstaAberto()
    {
        $limitLances = $this->qtdMinimaLances;
        $totalLances = count($this->getLances());

        if ($limitLances <= $totalLances) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return int
     */
    public function getQtdMinimaLances()
    {
        return $this->qtdMinimaLances;
    }

    /**
     * @param int $qtdMinimaLances
     */
    public function setQtdMinimaLances($qtdMinimaLances)
    {
        $this->qtdMinimaLances = $qtdMinimaLances;
    }

    /**
     * @return \Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param \Usuario $usuario
     */
    public function setUsuario(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getValorAtual($forceFloat = false)
    {
        if ($forceFloat) {
            return $this->valor_atual;
        }

        return number_format($this->valor_atual, 2, ',', '.');
    }

    /**
     * @param mixed $valor_atual
     */
    public function setValorAtual($valor_atual)
    {
        $this->valor_atual = $valor_atual;
    }
}

