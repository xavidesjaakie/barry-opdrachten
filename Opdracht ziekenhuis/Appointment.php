<?php
// Appointment.php


// in dit bestand wordt de klasse Appointment gedefinieerd. Een afspraak bestaat uit een patient, een dokter, een verpleegster, een datum en een tijdstip.
// De klasse bevat methodes om de kosten van de afspraak te berekenen en om de begin- en eindtijd van de afspraak te formatteren.
namespace Hospital;

class Appointment 
{
    //dit zijn de variabelen die een afspraak beschrijven
    private $patient;
    private $doctor;
    private $nurses = [];
    private $beginTime;
    private $endTime;
    public static $count = 0;
    public static $appointments = [];

    public function setAppointment($patient, $doctor,
        $nurse, $date, $time) 
        {
        $this->patient = $patient;
        $this->doctor = $doctor;
        foreach($nurss as $Nurse)
        {
            $this->addNurse($nurse);
        }
        $this->beginTime = $beginTime;
        $this->endTime = $endTime;
        self::$count++;
        // hier wordt de afspraak toegevoegd aan de lijst van afspraken
        self::$appointments[] = $this;
    }
    
    public function addNurse($nurse) 
    {
        $this->nurses[] = $nurse;
    }

    public function getDoctor() 
    {
        return $this->doctor;
    }
    public function getPatient() 
    {
        return $this->patient;
    }

    public function getNurses() 
    {
        return $this->nurses;
    }

    public function getBeginTime() 
    {
        return $this->beginTime->format('d-m-Y H:i');
    }

    public function getEndTime() 
    {
        return $this->endTime->format('d-m-Y H:i');
    }

    public function getTimeDifference() 
    {
        $timeDiff = $this->beginTime->diff($this->endTime);
        $partOfHour = ($timeDiff->format('%i')/60)*100 ;

        return $timeDiff->format('%h').".".$partOfHour;
    }

    // hier wordt de kost van de afspraak berekend
    // Dit gaat door de kosten van de dokter en de verpleegsters bij elkaar op te tellen.

    // de som is het aantal uren dat de dokter en de verpleegster aan de afspraak besteden vermeenigvuldigd met hun salaris.
    public function getCosts() 
    {
        $time = $this->getTimeDifference();
        $doctorCosts = $time * $this->doctor->getSalary();
        $nurseCosts = 0;
        foreach($this->nurses as $nurse) 
        {
            $nurseCosts += $time * $nurse->getSalary();
        }
        return $doctorCosts + $nurseCosts;
    }
}