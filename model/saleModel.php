<?php
class Sale
{
    private int $id;
    private DateTime $tgl_sale;
    private string $customer_name;
    private int $quantity;
    private int $total_price;

    /**
     * @param int $id
     * @param DateTime $tgl_sale
     * @param string $customer_name
     * @param int $quantity
     * @param int $total_price
     */
    public function __construct(int $id, DateTime $tgl_sale, string $customer_name, int $quantity, int $total_price)
    {
        $this->id = $id;
        $this->tgl_sale = $tgl_sale;
        $this->customer_name = $customer_name; // Fixed this line
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

    public function getTglSale(): string
    {
        return $this->tgl_sale->format('Y-m-d');
    }

    public function setTglSale(DateTime $tgl_sale): void
    {
        $this->tgl_sale = $tgl_sale;
    }

    public function getCustomerName(): string
    {
        return $this->customer_name;
    }

    public function setCustomerName(string $customer_name): void
    {
        $this->customer_name = $customer_name;
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
