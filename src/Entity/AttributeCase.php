<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="App\Repository\AttributeCaseRepository")
 */
class AttributeCase implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Attribute", inversedBy="cases")
     * @ORM\JoinColumn(nullable=false)
     */
    private $attribute;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;
    /**
     * @ORM\Column(type="integer")
     */
    private $sortOrder;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AttributeValue", mappedBy="value")
     */
    private $attributeValues;
    public function __construct()
    {
        $this->attributeValues = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
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
    public function getValue(): ?string
    {
        return $this->value;
    }
    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }
    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }
    public function setSortOrder(int $sortOrder): self
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }
    /**
     * @return Collection|AttributeValue[]
     */
    public function getAttributeValues(): Collection
    {
        return $this->attributeValues;
    }
    public function addAttributeValue(AttributeValue $attributeValue): self
    {
        if (!$this->attributeValues->contains($attributeValue)) {
            $this->attributeValues[] = $attributeValue;
            $attributeValue->setValue($this);
        }
        return $this;
    }
    public function removeAttributeValue(AttributeValue $attributeValue): self
    {
        if ($this->attributeValues->contains($attributeValue)) {
            $this->attributeValues->removeElement($attributeValue);
            // set the owning side to null (unless already changed)
            if ($attributeValue->getValue() === $this) {
                $attributeValue->setValue(null);
            }
        }
        return $this;
    }
    public function __toString()
    {
        return (string)$this->value;
    }
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'attributeId' => $this->getAttribute()->getId(),
            'value' => $this->getValue(),
        ];
    }
}