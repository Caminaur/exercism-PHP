<?php

declare(strict_types=1);

class Game
{
    private $frames;
    private $currentFrame;
    private $extraShot;
    private $isGameFinished;

    function __construct()
    {
        $this->frames = [];
        $this->isGameFinished = false;
        $this->currentFrame = 1;
        $this->extraShot = false;
    }

    public function score(): int
    {
        $frames = $this->frames;
        if (empty($frames)) throw new Exception("An unstarted game cannot be scored", 1);
        if (!$this->isGameFinished) throw new Exception("An incomplete game cannot be scored", 1);


        $score = 0;
        $rolls = [];

        // We put all the shots together in a list
        foreach ($frames as $frame) {
            foreach ($frame as $pins) {
                $rolls[] = $pins;
            }
        }

        $rollIndex = 0;

        for ($frame = 1; $frame <= 10; $frame++) {
            if (!isset($rolls[$rollIndex])) break;

            $firstRoll = $rolls[$rollIndex];
            $secondRoll = $rolls[$rollIndex + 1] ?? 0;
            $thirdRoll = $rolls[$rollIndex + 2] ?? 0;

            if ($firstRoll === 10) { // strike
                $score += 10 + $secondRoll + $thirdRoll;
                $rollIndex += 1;
            } elseif (($firstRoll + $rolls[$rollIndex + 1]) === 10) { // spare
                $score += 10 + $thirdRoll;
                $rollIndex += 2;
            } else {
                $score += $firstRoll + $secondRoll;
                $rollIndex += 2;
            }
        }

        return $score;
    }

    public function roll(int $pins): void
    {
        if ($pins < 0) throw new Exception("rolls cannot score negative points", 1);
        if ($pins > 10) throw new Exception("a roll cannot score more than 10 points", 1);
        if ($this->isGameFinished) throw new Exception("Game is already over", 1);

        // Count the number of frames played
        $frameCount = 0;
        $currentFrame = $this->currentFrame;

        $hasCurrentFrameStarted = isset($this->frames[$currentFrame]);

        if ($currentFrame === 10) { // last frame
            $this->frames[$currentFrame][] = $pins;
            $shots = $this->frames[$currentFrame];
            $rolls = count($shots);

            if ($rolls === 1 && $pins === 10) { // strike
                // We add 2 extra shots
                $this->extraShot = 2;
            } elseif ($rolls === 2) {
                if ($shots[0] === 10 || array_sum($shots) === 10) { // if there is a strike or spare
                    $this->extraShot = $this->extraShot ?? 1;
                } else {
                    // No more extra rolls its over
                    $this->isGameFinished = true;
                }
            } elseif ($rolls === 3) {
                // If we ever get to three rolls after that the game ends
                if ($shots[0] === 10 && $shots[1] !== 10 && ($shots[1] + $shots[2]) > 10) {
                    throw new Exception("two bonus rolls after a strike in the last frame cannot score more than 10 points", 1);
                }
                $this->isGameFinished = true;
            }
        } else {
            if ($hasCurrentFrameStarted) {
                $previosValue = $this->frames[$currentFrame][0];
                if ($previosValue + $pins > 10) {
                    throw new Exception("Two Rolls can not score more than 10 points!", 1);
                }

                $this->frames[$currentFrame][] = $pins;
                if ($pins == 10 || count($this->frames[$currentFrame]) == 2) {
                    $this->currentFrame++;
                }
            } else {
                $this->frames[$currentFrame][] = $pins;
                if ($pins == 10) {
                    $this->currentFrame++;
                }
            }
        }


        // If 10 frames are completed, prevent further rolls
        if ($frameCount > 10) {
            throw new Exception("Cannot roll if the game already has ten frames");
        }
    }
}
