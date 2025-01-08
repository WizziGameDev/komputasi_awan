<?php

class Supplier
{
    private int $id;
    private string $name;
    private string $email;
    private string $contact;
    private string $address;

    /**
     * Constructor
     *
     * @param int|null $id
     * @param string $name
     * @param string $email
     * @param string $contact
     * @param string $address
     */
    public function __construct(?int $id, string $name, string $email, string $contact, string $address)
    {
        $this->id = $id ?? 0; // Default to 0 if no ID provided
        $this->name = $name;
        $this->email = $email;
        $this->contact = $contact;
        $this->address = $address;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getContact(): string
    {
        return $this->contact;
    }

    public function setContact(string $contact): void
    {
        $this->contact = $contact;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }
}
