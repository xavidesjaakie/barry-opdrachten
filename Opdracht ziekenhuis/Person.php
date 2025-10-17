<?php
// Person.php

namespace Hospital;

abstract class Person
{
    private $name;
    private $role;

    public function __construct($name, $role)
    {
        $this->name = $name;
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}