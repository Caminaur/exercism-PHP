<?php

declare(strict_types=1);
class KindergartenGarden
{
    private const PLANT_MAP = ["R" => 'radishes', "C" => 'clover', "G" => 'grass', "V" => 'violets'];
    private const STUDENTEN = [
        'Alice',
        'Bob',
        'Charlie',
        'David',
        'Eve',
        'Fred',
        'Ginny',
        'Harriet',
        'Ileana',
        'Joseph',
        'Kincaid',
        'Larry'
    ];
    private $line_1 = [];
    private $line_2 = [];
    public function __construct(string $diagram)
    {
        [$this->line_1, $this->line_2] = explode("\n", $diagram);
    }
    private function codeToName(string $plant): string
    {
        return self::PLANT_MAP[$plant] ?? "unknown";
    }
    public function plants(string $student): array
    {
        $key = array_search($student, self::STUDENTEN);

        $plant1Key = $key * 2;
        $plant2Key = $plant1Key + 1;

        $line_1 = $this->line_1;
        $line_2 = $this->line_2;

        $flowers = [];
        $flowers[] = $this->codeToName($line_1[$plant1Key]);
        $flowers[] = $this->codeToName($line_1[$plant2Key]);
        $flowers[] = $this->codeToName($line_2[$plant1Key]);
        $flowers[] = $this->codeToName($line_2[$plant2Key]);
        return $flowers;
    }
}
