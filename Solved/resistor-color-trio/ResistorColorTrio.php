<?php

declare(strict_types=1);

class ResistorColorTrio
{
    private $colors;
    private $unitConversions;

    public function __construct()
    {
        $this->colors = [
            "black" => 0,
            "brown" => 1,
            "red" => 2,
            "orange" => 3,
            "yellow" => 4,
            "green" => 5,
            "blue" => 6,
            "violet" => 7,
            "grey" => 8,
            "white" => 9
        ];
        $this->unitConversions = [
            4 => ["kiloohms",3],
            5 => ["kiloohms",3],
            6 => ["kiloohms",3],
            7 => ["megaohms",6],
            8 => ["megaohms",6],
            9 => ["megaohms",6],
            10 => ["gigaohms",9],
            11 => ["gigaohms",9],
            12 => ["gigaohms",9],
            13 => ["teraohms",12],
            14 => ["teraohms",12],
            15 => ["teraohms",12],
        ];
    }

    public function label(array $resistorColors): string
    {
        $color1 = $this->colors[$resistorColors[0]] ?? null;
        $color2 = $this->colors[$resistorColors[1]] ?? null;
        $color3 = $this->colors[$resistorColors[2]] ?? null;

        $number = intval($color1.$color2) * pow(10,$color3); // ej 200.000
        
        
        $lenght = strlen(strval($number)); // longitud ej 4
        $pow = $this->unitConversions[$lenght][1] ?? 0; // 4
        $unit = $this->unitConversions[$lenght][0] ?? "ohms"; // ohms

        $response = $number / pow(10,$pow);
        return "{$response} $unit";
   

    }
}
