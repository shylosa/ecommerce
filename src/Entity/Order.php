<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="`order`")
 */
class Order
{
    // новый, заказан, отправлен, доставлен
    const STATUS_NEW = 1;
    const STATUS_ORDERED = 2;
    const STATUS_SENT = 3;
    const STATUS_DELIVERED = 4;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    /**
     * @ORM\Column(type="integer")
     */
    private $status;
    /**
     * @ORM\Column(type="boolean")
     */
    private $isPaid;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     */
    private $user;
    /**
     * @ORM\Column(type="integer")
     */
    private $amount;
    /**
     * @var OrderItem[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\OrderItem",
     *     mappedBy="order", cascade={"persist"}, orphanRemoval=true)
     */
    private $orderItems;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"makeOrder"})
     */
    private $phone;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"makeOrder"})
     * @Assert\Email(checkMX=true, checkHost=true, groups={"makeOrder"})
     */
    private $email;
    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\NotBlank(groups={"makeOrder"})
     */
    private $address;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->status = self::STATUS_NEW;
        $this->isPaid = false;
        $this->amount = 0;
        $this->orderItems = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
    public function getStatus(): ?int
    {
        return $this->status;
    }
    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }
    public function getIsPaid(): ?bool
    {
        return $this->isPaid;
    }
    public function setIsPaid(bool $isPaid): self
    {
        $this->isPaid = $isPaid;
        return $this;
    }
    public function getUser(): ?User
    {
        return $this->user;
    }
    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }
    public function getAmount(): ?int
    {
        return $this->amount;
    }
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }
    /**
     * @return Collection|OrderItem[]
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }
    public function addOrderItem(OrderItem $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems[] = $orderItem;
            $orderItem->setOrder($this);
        }
        $this->updateAmount();
        return $this;
    }
    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->contains($orderItem)) {
            $this->orderItems->removeElement($orderItem);
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrder() === $this) {
                $orderItem->setOrder(null);
            }
        }
        $this->updateAmount();
        return $this;
    }
    public function updateAmount()
    {
        $amount = 0;
        foreach ($this->orderItems as $item) {
            $amount += $item->getAmount();
        }
        $this->setAmount($amount);
    }
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }
    public function getAddress(): ?string
    {
        return $this->address;
    }
    public function setAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }
    public function getLastName(): ?string
    {
        return $this->lastName;
    }
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }
}