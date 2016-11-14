<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Passagem
 *
 * @ORM\Table(name="passagem", indexes={@ORM\Index(name="fk_passagem_cidade1_idx", columns={"cidade"}), @ORM\Index(name="fk_passagem_estado1_idx", columns={"estado"}), @ORM\Index(name="fk_passagem_agencia1_idx", columns={"agencia"}), @ORM\Index(name="fk_passagem_categoria1_idx", columns={"categoria"}), @ORM\Index(name="fk_passagem_leilao1_idx", columns={"leilao"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PassagemRepository")
 */
class Passagem
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idpassagem", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=45, nullable=true)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=45, nullable=true)
     */
    private $descricao;

    /**
     * @var \Agencia
     *
     * @ORM\ManyToOne(targetEntity="Agencia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agencia", referencedColumnName="idagencia")
     * })
     */
    private $agencia;

    /**
     * @var \Categoria
     *
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria", referencedColumnName="idcategoria")
     * })
     */
    private $categoria;

    /**
     * @var \Cidade
     *
     * @ORM\ManyToOne(targetEntity="Cidade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cidade", referencedColumnName="idcidade")
     * })
     */
    private $cidade;

    /**
     * @var \Estado
     *
     * @ORM\ManyToOne(targetEntity="Estado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado", referencedColumnName="idestado")
     * })
     */
    private $estado;

    /**
     * @var \Leilao
     *
     * @ORM\ManyToOne(targetEntity="Leilao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="leilao", referencedColumnName="idleilao")
     * })
     */
    private $leilao;

    /**
     * @ORM\Column(name="valor", type="float", scale=2)
     */
    protected $valor;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $idpassagem
     */
    public function setId($idpassagem)
    {
        $this->id = $idpassagem;
    }

    /**
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return Agencia
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * @param Agencia $agencia
     */
    public function setAgencia(Agencia $agencia)
    {
        $this->agencia = $agencia;
    }

    /**
     * @return Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param \Categoria $categoria
     */
    public function setCategoria(Categoria $categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * @return Cidade
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @param \Cidade $cidade
     */
    public function setCidade(Cidade $cidade)
    {
        $this->cidade = $cidade;
    }

    /**
     * @return Estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param \Estado $estado
     */
    public function setEstado(Estado $estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return Leilao
     */
    public function getLeilao()
    {
        return $this->leilao;
    }

    /**
     * @param \Leilao $leilao
     */
    public function setLeilao(Leilao $leilao)
    {
        $this->leilao = $leilao;
    }

    /**
     * @return mixed
     */
    public function getValor($forceFloat = false)
    {
        if ($forceFloat) {
            return $this->valor;
        }

        return number_format($this->valor, 2, ',', '.');
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }
}

