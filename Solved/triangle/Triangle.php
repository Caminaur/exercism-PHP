<?php

declare(strict_types=1);

class Triangle
{
    public $a;
    public $b;
    public $c;

    public function __construct(float $a, float $b, float $c)
    {
        if($a<=0||$b<=0||$c<=0) throw new Exception("Triangles with no size are illegal");
        
        // Verifing Triangle innequity
        if ($a>($b+$c) || $b>($a+$c) || $c>($a+$b)) throw new Exception("Invalid Triangle");

        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }

    public function kind(): string
    {
        $a = $this->a;
        $b = $this->b;
        $c = $this->c;

        if ($a==$b && $b==$c) return "equilateral";
        if ($a==$b || $b==$c || $a==$c) return "isosceles";

        return "scalene";
    }
}
