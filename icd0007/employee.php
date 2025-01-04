<?php

class employee
{
    public int $id;
    public string $firstName;
    public string $lastName;
    public string $position;
    public ?string $picture;


    public function __construct(int $id, string $firstName, string $lastName, string $position, ?string $picture = null)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->position = $position;
        $this->picture = $picture ;
    }

    public function __toString(): string
    {
        return "$this->firstName $this->lastName";
    }





}