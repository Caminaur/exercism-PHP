<?php

declare(strict_types=1);

function meetup_day(int $year, int $month, string $which, string $weekday): DateTimeImmutable
{
    // We step on the first day of the month
    $date_start = new DateTime("{$year}-{$month}-1");
    // $month_length = cal_days_in_month(0, $month, $year);
    $month_length = (int) $date_start->format('t');
    
    $starting_day = $date_start->format("l"); 
    $id_to_day = [ 0 => "Sunday",1 => "Monday",2 => "Tuesday",3 => "Wednesday",4 => "Thursday",5 => "Friday",6 => "Saturday"];
    
    $month_days = [];
    $control_id = array_filter($id_to_day,function($d,$id) use($starting_day){
        return ($d==$starting_day)?true:false;
    },ARRAY_FILTER_USE_BOTH);
    $control_id = array_keys($control_id)[0]; // ID of the day

    
    for ($i=0; $i < $month_length ; $i++) { 
        $month_days[$i] = $id_to_day[$control_id];
        $control_id = ($control_id+1) % 7; 
    }

    $which_dict = [
        'first' => 1,
        'second' => 2,
        'third' => 3,
        'fourth' => 4,
        'last' => 'last',
        'teenth' => 'teenth'
    ];

    $actual_date = '';
    $day_number = $which_dict[$which]; // 1 2 3 4 5
    if (is_int($day_number)) {
        $appeared = 0;
        for ($i=0; $i <= count($month_days) ; $i++) { 
            if ($month_days[$i]==$weekday) {
                $appeared++;
                if ($appeared==$day_number) {
                    $actual_date = $i + 1;
                    break;
                }
            }
        }
    } elseif($day_number=="last"){
        for ($i=0; $i < count($month_days) ; $i++) { 
            if ($month_days[$i]==$weekday) {
                $actual_date = $i + 1;
            }
        }
    } else{
        for ($i=12; $i <19 ; $i++) { 
            if ($month_days[$i]==$weekday) {
                $actual_date = $i + 1;break;
            }
        }
    }

    if (!$actual_date) {
        throw new Exception("No valid meetup date found.");
    }
    return new DateTimeImmutable("{$year}-{$month}-{$actual_date}");
}

// https://www.php.net/manual/en/dateinterval.createfromdatestring.php
// https://www.php.net/manual/en/class.dateinterval.php
// https://www.php.net/manual/en/language.oop5.cloning.php