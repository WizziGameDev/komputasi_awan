<?php

class Item
{
    private int $id; // Ganti dari string ke int untuk id

    private string $name;

    private int $price;

    private int $stock;

    private string $category;

    private int $size;

    /**
     * @param int $id
     * @param string $name
     * @param int $price
     * @param int $stock
     * @param int $size
     * @param string $category
     */
    public function __construct(int $id, string $name, int $price, int $stock, string $category, int $size)
    {
        $this->id = $id; // Ganti code ke id
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->size = $size;
        $this->category = $category;
    }

    public function getId(): int // Ganti getCode menjadi getId
    {
        return $this->id;
    }

    public function setId(int $id): void // Ganti setCode menjadi setId
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getSize(): int {
        return $this->size;
    }

    public function setSize(int $size):void {
        $this->size = $size;
    }
}
