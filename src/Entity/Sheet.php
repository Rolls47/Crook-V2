<?php

namespace App\Entity;

use App\Repository\SheetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SheetRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("slug")
 */
class Sheet implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     * @Assert\Length(max="255", maxMessage="Le titre ne doit pas dépasser {{ limit }}")
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     * @Assert\Length(max="255", maxMessage="Le description ne doit pas dépasser {{ limit }}")
     */
    private string $description;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     */
    private string $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $createAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $updateAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sheets")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $author;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="sheets")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Language $language;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $slug;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }
    /**
     * @ORM\PrePersist
     * @return $this
     */
    public function setCreateAt(): self
    {
        $this->createAt = new \DateTime();

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    /**
     * @ORM\PreUpdate()
     * @return $this
     */
    public function setUpdateAt(): self
    {
        $this->updateAt = new \DateTime();

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }


    public function jsonSerialize()
    {
        return [
            'title' => $this->getTitle(),
            'slug' => $this->getSlug(),
            'language' => $this->getLanguage()->getSlug(),
        ];
    }


}
