<?php

class Purchase
{
    private int $id;

    private DateTime $tgl_purchase;

    private string $supplier_name;

    private int $quantity;

    private int $total_price;

    /**
     * @param int $id
     * @param DateTime $tgl_purchase
     * @param string $supplier_name // Updated parameter type
     * @param int $quantity
     * @param int $total_price
     */
    public function __construct(int $id, DateTime $tgl_purchase, string $supplier_name, int $quantity, int $total_price)
    {
        $this->id = $id;
        $this->tgl_purchase = $tgl_purchase;
        $this->supplier_name = $supplier_name;
        $this->quantity = $quantity;
        $this->total_price = $total_price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTglPurchase(): string
    {
        return $this->tgl_purchase->format('Y-m-d');
    }

    public function setTglPurchase(DateTime $tgl_purchase): void
    {
        $this->tgl_purchase = $tgl_purchase;
    }

    public function getSupplierName(): string
    {
        return $this->supplier_name;
    }

    public function setSupplierName(int $supplier_name): void 
    {
        $this->supplier_id = $supplier_name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getTotalPrice(): int
    {
        return $this->total_price;
    }

    public function setTotalPrice(int $total_price): void
    {
        $this->total_price = $total_price;
    }
}
