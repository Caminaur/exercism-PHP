<?php

declare(strict_types=1);

class SpiralMatrix
{
    public function draw(int $n): array
    {
        $arr = [];

        if ($n === 0) {
            return $arr;
        }
        for ($i = 0; $i < $n; $i++) {
            $arr[] = array_fill(0, $n, NULL);
        }


        $i = 0;
        $val = 1;
        $currentLine = 0;
        $direcction = 'RIGHT';
        $finished = false;

        $arr[$currentLine][$i] = $val;
        while (!$finished) {
            $canGoRight = array_key_exists($i + 1, $arr[$currentLine]) && $arr[$currentLine][$i + 1] === NULL;
            $canGoDown = array_key_exists($currentLine + 1, $arr) && $arr[$currentLine + 1][$i] === NULL;
            $canGoLeft = array_key_exists($i - 1, $arr[$currentLine]) && $arr[$currentLine][$i - 1] === NULL;
            $canGoUp = array_key_exists($currentLine - 1, $arr) && $arr[$currentLine - 1][$i] === NULL;
            switch ($direcction) {
                case 'RIGHT':
                    if ($canGoRight) {
                        $val++;
                        $i++;
                        $arr[$currentLine][$i] = $val;
                    } elseif (!$canGoRight && !$canGoDown) {
                        $finished = true;
                    } else {
                        $direcction = "DOWN";
                    }
                    break;
                case 'DOWN':
                    if ($canGoDown) {
                        $currentLine++;
                        $val++;
                        $arr[$currentLine][$i] = $val;
                    } elseif (!$canGoDown && !$canGoLeft) {
                        $finished = true;
                    } else {
                        $direcction = "LEFT";
                    }
                    break;
                case 'LEFT':
                    if ($canGoLeft) {
                        $val++;
                        $arr[$currentLine][$i - 1] = $val;
                        $i--;
                    } elseif (!$canGoLeft && !$canGoUp) {
                        $finished = true;
                    } else {
                        $direcction = "UP";
                    }
                    break;
                case 'UP':
                    if ($canGoUp) {
                        $val++;
                        $currentLine--;
                        $arr[$currentLine][$i] = $val;
                    } elseif (!$canGoUp && !$canGoRight) {
                        $finished = true;
                    } else {
                        $direcction = "RIGHT";
                    }
                    break;
            }
        }
        return $arr;
    }
}
