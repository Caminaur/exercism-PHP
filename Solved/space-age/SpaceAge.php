<?php

declare(strict_types=1);

class SpaceAge
{
    private $orbital_periods = [
        "mercury" => 0.2408467,
        "venus"   => 0.61519726,
        "earth"   => 1.0,
        "mars"    => 1.8808158,
        "jupiter" => 11.862615,
        "saturn"  => 29.447498,
        "uranus"  => 84.016846,
        "neptune" => 164.79132
    ];

    private $age_in_seconds;
    

    public function __construct(int $seconds)
    {
        $this->age_in_seconds = $seconds;
    }

    private function seconds_to_years($age_in_seconds){
        return $age_in_seconds / 31557600;
    }

    private function calculate_age($planet)
    {
        return $this->seconds_to_years($this->age_in_seconds / $this->orbital_periods[$planet]);
    }

    public function earth(): float
    {
        return $this->calculate_age(__FUNCTION__);
    }

    public function mercury(): float
    {
        return $this->calculate_age(__FUNCTION__);
    }

    public function venus(): float
    {
        return $this->calculate_age(__FUNCTION__);
    }

    public function mars(): float
    {
        return $this->calculate_age(__FUNCTION__);
    }

    public function jupiter(): float
    {
        return $this->calculate_age(__FUNCTION__);
    }

    public function saturn(): float
    {
        return $this->calculate_age(__FUNCTION__);
    }

    public function uranus(): float
    {
        return $this->calculate_age(__FUNCTION__);  
    }

    public function neptune(): float
    {
        return $this->calculate_age(__FUNCTION__);
    }
}
