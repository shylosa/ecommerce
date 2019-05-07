<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name = "orderNumber")
 */
class Order
{

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
    private $dateCreate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $orderPrice;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $paymentState;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderItem", mappedBy="orderNumber")
     */
    private $orderItems;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
        $this->dateCreate= new DateTime();
        $this->state = self::STATUS_NEW;
        $this->orderPrice = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreate(): ?string
    {
        return $this->dateCreate;
    }

    public function setDateCreate(string $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getOrderPrice(): ?int
    {
        return $this->orderPrice;
    }

    public function setOrderPrice(?int $orderPrice): self
    {
        $this->orderPrice = $orderPrice;

        return $this;
    }

    public function getPaymentState(): ?bool
    {
        return $this->paymentState;
    }

    public function setPaymentState(bool $paymentState): self
    {
        $this->paymentState = $paymentState;

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
            $orderItem->setOrderNumber($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->contains($orderItem)) {
            $this->orderItems->removeElement($orderItem);
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrderNumber() === $this) {
                $orderItem->setOrderNumber(null);
            }
        }

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
}
