<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="App\Repository\AttributeValueRepository")
 */
class AttributeValue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="attributeValues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Attribute", inversedBy="attributeValues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $attribute;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AttributeCase", inversedBy="attributeValues")
     */
    private $value;
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getProduct(): ?Product
    {
        return $this->product;
    }
    public function setProduct(?Product $product): self
    {
        $this->product = $product;
        return $this;
    }
    public function getAttribute(): ?Attribute
    {
        return $this->attribute;
    }
    public function setAttribute(?Attribute $attribute): self
    {
        $this->attribute = $attribute;
        return $this;
    }
    public function getValue(): ?AttributeCase
    {
        return $this->value;
    }
    public function setValue(?AttributeCase $value): self
    {
        $this->value = $value;
        return $this;
    }
}