<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Judgments
 *
 * @ORM\Table(name="judgments")
 * @ORM\Entity
 */
class Judgments
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="plaintiff", type="string", length=5, nullable=false, options={"fixed"=true})
     */
    private $plaintiff;

    /**
     * @var string
     *
     * @ORM\Column(name="defendant", type="string", length=5, nullable=false, options={"fixed"=true})
     */
    private $defendant;

    /**
     * @var string
     *
     * @ORM\Column(name="win", type="string", length=5, nullable=false, options={"fixed"=true})
     */
    private $win;

    /**
     * @var int
     *
     * @ORM\Column(name="point", type="integer", nullable=false)
     */
    private $point;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaintiff(): ?string
    {
        return $this->plaintiff;
    }

    public function setPlaintiff(string $plaintiff): self
    {
        $this->plaintiff = $plaintiff;

        return $this;
    }

    public function getDefendant(): ?string
    {
        return $this->defendant;
    }

    public function setDefendant(string $defendant): self
    {
        $this->defendant = $defendant;

        return $this;
    }

    public function getWin(): ?string
    {
        return $this->win;
    }

    public function setWin(string $win): self
    {
        $this->win = $win;

        return $this;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(int $point): self
    {
        $this->point = $point;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }


}
