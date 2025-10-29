<?php

declare(strict_types=1);

class KindergartenGarden
{
    private $plants_DICT = [
        "R" => 'radishes',
        "C" => 'clover',
        "G" => 'grass',
        "V" => 'violets'
    ];
    private $studenten = ['Alice', 'Bob', 'Charlie', 'David', 'Eve', 'Fred', 'Ginny', 'Harriet', 'Ileana', 'Joseph', 'Kincaid', 'Larry'];
    private $line_1 = [];
    private $line_2 = [];
    public function __construct(string $diagram)
    {
        $lines = explode("\n", $diagram);
        $this->line_1 = $lines[0];
        $this->line_2 = $lines[1];
    }

    private function codeToName(string $plant): string
    {
        return  $this->plants_DICT[$plant];
    }
    public function plants(string $student): array
    {
        $key = array_search($student, $this->studenten);
        $k = $key * 2;
        $line_1 = $this->line_1;
        $line_2 = $this->line_2;
        $flowers = [];
        $flowers[] =  $this->codeToName($line_1[$k]);
        $flowers[] =  $this->codeToName($line_1[$k + 1]);
        $flowers[] =  $this->codeToName($line_2[$k]);
        $flowers[] =  $this->codeToName($line_2[$k + 1]);
        return $flowers;
    }
}
