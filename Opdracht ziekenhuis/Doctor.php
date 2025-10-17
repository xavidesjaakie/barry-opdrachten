<?php
// Doctor.php

namespace Hospital;

class Doctor extends Staff
{
    public function setSalary($ammount)
    {
        // TODO: implement setSalary() method.
        $this->salary = $ammount;
    }

    public function getSalary()
    {
        return $this->salary;
    }
}