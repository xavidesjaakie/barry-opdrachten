<?php
// index.php

//in dit bestand worden alle klassen geïmporteerd en wordt er een nieuwe instantie van elke klasse aangemaakt.
// vervolgens worden er een aantal afspraken gemaakt en worden deze in een tabel weergeven.

require 'vendor/autoload.php';

use Hospital\Person;
use Hospital\Patient;
use Hospital\Doctor;
use Hospital\Nurse;
use Hospital\Appointment;

$patient1 = new Patient('John','Patient', 100);
$patient2 = new Patient('Jane', 'Patient', 100);
$patient3 = new Patient('Klaas', 'Patient', 100);
$patient4 = new Patient('Piet', 'Patient', 100);

$doctor1 = new Doctor('Dr. Smith', 'Doctor');
$doctor1->setSalary(100);
$doctor2 = new Doctor('Dr. Jones', 'Doctor');
$doctor2->setSalary(150);
$doctor3 = new Doctor('Dr. Brown', 'Doctor');
$doctor3->setSalary(200);

$nurse1 = new Nurse('Nurse Kelly', 'Nurse');
$nurse1->setSalary(2400);
$nurse2 = new Nurse('Nurse Adams', 'Nurse');
$nurse2->setSalary(2500);
$nurse3 = new Nurse('Nurse Johnson', 'Nurse');
$nurse3->setSalary(2600);

$appointment1 = new Appointment();
$appointment1->setAppointment($patient1, $doctor1, [$nurse1, $nurse2], new DateTime('2025-11-02 10:00'), new DateTime('2025-11-02 11:00'));

$appointment2 = new Appointment();
$appointment2->setAppointment($patient2, $doctor2, [$nurse2, $nurse3], new DateTime('2025-11-07 11:00'), new DateTime('2025-11-07 12:00'));

$appointment3 = new Appointment();
$appointment3->setAppointment($patient3, $doctor3, [$nurse1, $nurse3], new DateTime('2025-11-10 09:00'), new DateTime('2025-11-10 10:00'));


//var_dump($appointments);

//print Appointment: :$count;
//var_dump(Appointment::$appointments);

print "<table border='1'>
        <tr>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Nurses</th>
            <th>Begin</th>
            <th>End</th>
            <th>Price</th>
        </tr>";

        foreach(Appointment::$appointments as $appointment)
        {
            print "<tr>
                    <td>".$appointment->getPatient()->getName()."</td>
                    <td>".$appointment->getDoctor()->getName()."</td>
                    <td><ul>";
                    foreach($appointment->getNurses() as $nurse)
                    {
                        print "<li>".$nurse->getName()."</li>";
                    }
                    print "</ul></td>
                    <td>".$appointment->getBeginTime()->format('Y-m-d H:i')."</td>
                    <td>".$appointment->getEndTime()->format('Y-m-d H:i')."</td>
                    <td>".$appointment->getCosts()."</td>
                </tr>";
        }
        

print "</table>";