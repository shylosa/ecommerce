<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="App\Repository\AttributeRepository")
 */
class Attribute
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AttributeCase", mappedBy="attribute", orphanRemoval=true, cascade={"all"})
     */
    private $cases;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", mappedBy="attributes")
     */
    private $categories;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AttributeValue", mappedBy="attribute", orphanRemoval=true)
     */
    private $attributeValues;
    public function __construct()
    {
        $this->cases = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->attributeValues = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
    /**
     * @return Collection|AttributeCase[]
     */
    public function getCases(): Collection
    {
        return $this->cases;
    }
    public function addCase(AttributeCase $case): self
    {
        if (!$this->cases->contains($case)) {
            $this->cases[] = $case;
            $case->setAttribute($this);
        }
        return $this;
    }
    public function removeCase(AttributeCase $case): self
    {
        if ($this->cases->contains($case)) {
            $this->cases->removeElement($case);
            // set the owning side to null (unless already changed)
            if ($case->getAttribute() === $this) {
                $case->setAttribute(null);
            }
        }
        return $this;
    }
    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }
    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addAttribute($this);
        }
        return $this;
    }
    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            $category->removeAttribute($this);
        }
        return $this;
    }
    public function __toString()
    {
        return $this->getName();
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
            $attributeValue->setAttribute($this);
        }
        return $this;
    }
    public function removeAttributeValue(AttributeValue $attributeValue): self
    {
        if ($this->attributeValues->contains($attributeValue)) {
            $this->attributeValues->removeElement($attributeValue);
            // set the owning side to null (unless already changed)
            if ($attributeValue->getAttribute() === $this) {
                $attributeValue->setAttribute(null);
            }
        }
        return $this;
    }
}