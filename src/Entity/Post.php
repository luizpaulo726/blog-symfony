<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: 'O título é obrigatório.')]
    #[Assert\Length(
        min: 3,
        max: 200,
        minMessage: 'O título deve ter pelo menos {{ limit }} caracteres.',
        maxMessage: 'O título deve ter no máximo {{ limit }} caracteres.'
    )]
    private ?string $titulo = null;

    #[ORM\Column(length: 300, nullable: true)]
    #[Assert\Length(max: 300, maxMessage: 'O resumo deve ter no máximo {{ limit }} caracteres.')]
    private ?string $resumo = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'O conteúdo é obrigatório.')]
    #[Assert\Length(min: 10, minMessage: 'O conteúdo deve ter pelo menos {{ limit }} caracteres.')]
    private ?string $conteudo = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $categoria = null;

    #[ORM\Column]
    private bool $publicado = false;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Usuario $autor = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $criadoEm = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $atualizadoEm = null;

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->criadoEm = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->atualizadoEm = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(?string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getResumo(): ?string
    {
        return $this->resumo;
    }

    public function setResumo(?string $resumo): static
    {
        $this->resumo = $resumo;

        return $this;
    }

    public function getConteudo(): ?string
    {
        return $this->conteudo;
    }

    public function setConteudo(?string $conteudo): static
    {
        $this->conteudo = $conteudo;

        return $this;
    }

    public function getCategoria(): ?string
    {
        return $this->categoria;
    }

    public function setCategoria(?string $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function isPublicado(): bool
    {
        return $this->publicado;
    }

    public function setPublicado(bool $publicado): static
    {
        $this->publicado = $publicado;

        return $this;
    }

    public function getAutor(): ?Usuario
    {
        return $this->autor;
    }

    public function setAutor(?Usuario $autor): static
    {
        $this->autor = $autor;

        return $this;
    }

    public function getCriadoEm(): ?\DateTimeImmutable
    {
        return $this->criadoEm;
    }

    public function getAtualizadoEm(): ?\DateTimeImmutable
    {
        return $this->atualizadoEm;
    }
}
