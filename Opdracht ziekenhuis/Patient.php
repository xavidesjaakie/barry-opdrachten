<?php
// Patient.php

namespace Hospital;

class Patient extends Person
{
    private $payment;

    public function __construct($name, $role, $payment)
    {
        $this->payment = $payment;
        parent::__construct($name, $age);
    }
}