<?php

declare(strict_types=1);

class Clock
{
    private $hours;
    private $minutes;

    public function __construct(int $hours=0,int $minutes=0)
    {
        $normalize = $this->calculateMinutes($minutes);
        $minutes = $normalize[0];
        $hourOffset = $normalize[1];

        $hours = $hours+$hourOffset;
        $hours = $this->calculateHours($hours);
        
        $this->hours = $hours;
        $this->minutes = $minutes;
    }
    /**
     * This class implements PHP's magic method __toString().
     *
     * By implementing this method, the class adheres to the `Stringable` interface.
     * When an object of this class is used in string context (e.g., echo or string cast),
     * this method is automatically called.
     *
     * More on `Stringable`: https://www.php.net/manual/en/class.stringable.php
     *
     * @return string The string representation of the Clock object
     */
    public function __toString(): string
    {
        $this->calculateTime();

        $hours = str_pad(strval($this->hours),2,"0",STR_PAD_LEFT);
        $minutes = str_pad(strval($this->minutes),2,"0",STR_PAD_LEFT);

        return "{$hours}:{$minutes}";
    }

    private function calculateTime($addedMinutes=0, $substractMinutes=0):void
    {
        $hours = $this->hours;
        $minutes = $this->minutes + $addedMinutes - $substractMinutes;
        while ($minutes<0){
            $minutes = $minutes + 60;
            $hours--;
        }

        $hours = $this->calculateHours($hours);


        while ($minutes>=60){
            $hours = ($hours+1) % 24;
            $minutes = $minutes - 60;
        }
        $this->hours = $hours;
        $this->minutes = $minutes;
    }

    private function calculateHours($n)
    {
        return $n>=0 ? $n % 24 : (24 + ($n%24));
    }
    private function calculateMinutes($minutes) : array
    {
        $hourOffset  = 0;
        if ($minutes>=0) {
            while ($minutes>60){
                $minutes = $minutes - 60;
                $hourOffset ++;   
            };
            
        } else{
            while ($minutes<0){
                $minutes = $minutes + 60;
                $hourOffset --;
            };
        }
        return [$minutes,$hourOffset ];
    }

    public function add($n){
        $this->minutes += $n;
        $this->calculateTime();
        return $this;
    }

    public function sub($n){
        $this->minutes -= $n;
        $this->calculateTime();
        return $this;
    }
}
