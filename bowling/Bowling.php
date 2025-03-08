<?php
declare(strict_types=1);

class Game
{
    private $currentScore;
    private $shots;
    private $isGameFinished;

    function __construct()
    {
        $this->shots=[];
        $this->isGameFinished=false;
        $this->currentScore=0;
    }
    // 10 frames
    // each frame 2 shots
        // if strike 
            // +20
            // only 1 shot
        // if spare
            // first throw points + 10
            // 2 shots
        // no spare
            // first throw points + second throw points
    // last frame
        // 3 shots
        // 3 strikes
            // +30
    public function score(): int
    {
        $shots = $this->shots;
        $score = 0;
        $shotIndex = 0; // para tener nocion de que tiro estamos hablando

        if (empty($shots)) throw new Exception("an unstarted game cannot be scored", 1);
        
        // los 10 turnos
        for ($frame = 1; $frame <= 10; $frame++) {
            
            $first = $shots[$shotIndex]?? 0; // 6
            $second = $shots[$shotIndex + 1]?? 0; // 3
            
            // Incomplete game

            // en caso de hacer 12 strikes (juego perfecto)
            $minRollsRequired = 12; 
            if (count($shots) < $minRollsRequired) throw new Exception("An incomplete game cannot be scored", 1);

            
            if ($frame==10) {
                $third = $shots[$shotIndex + 2]; // 6
                if ($first==10) {
                    if ($second!=10 && $second+$third>10) throw new Exception("two bonus rolls after a strike in the last frame cannot score more than 10 points", 1);
                }
                $this->isGameFinished=true;
                $score += $first + $second + $third; continue;
            }
            
            if ($first == 10) { // Strike
                // si existen los siguientes valores los sumamos sino sumamos 0
                $score += 10 + $second + ($shots[$shotIndex + 2] ?? 0);
                $shotIndex += 1; // aqui se puede pasar tanto al siguiente frame como al siguiente shot
            } 
            // caso de Spare
            elseif (($first + $second) == 10) { 
                // aqui devemos sumar el siguiente numero.
                $nextShotAfterSpare = $shots[$shotIndex + 2];
                $score += 10 + ($nextShotAfterSpare ?? 0);
                // debemos asegurarnos de saltear el 2do tiro ya que lo sumamos aqui. Y podemos pasar al siguiente Frame
                $shotIndex += 2;
            }
            // Normal
            else {
                if ($first + $second>10) throw new Exception("two rolls in a frame cannot score more than 10 points", 1);
                $score += $first + $second;
                $shotIndex += 2; // Move two shots ahead
            }
        }

        return $score;
    }

    public function roll(int $pins): void
    {
        if ($pins<0) throw new Exception("rolls cannot score negative points", 1);
        if ($pins>10) throw new Exception("a roll cannot score more than 10 points", 1);


        // Count the number of frames played
        $frameCount = 0;
        $shotIndex = 0;
        $totalShots = count($this->shots);

        while ($shotIndex < $totalShots && $frameCount<10) {

            if ($frameCount==10) {
                var_dump($frameCount);
                $shotIndex += 1 + ($this->shots[$shotIndex+1]) ?? 0 + ($this->shots[$shotIndex+2]) ?? 0;  
            } else{
                if ($this->shots[$shotIndex] == 10) {
                    $shotIndex += 1; 
                } else {
                    $shotIndex += 2;
                }
            }


            $frameCount++;
        }

        // If 10 frames are completed, prevent further rolls
        if ($frameCount > 10) {
            throw new Exception("Cannot roll if the game already has ten frames");
        }

        $this->shots[] = $pins;
    }
}
