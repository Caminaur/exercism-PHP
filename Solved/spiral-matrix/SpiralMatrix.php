<?php

declare(strict_types=1);

class SpiralMatrix
{
    public function draw(int $n): array
    {
        $arr = [];
        $finished = false;

        if ($n === 0) {
            return $arr;
        }
        for ($i = 0; $i < $n; $i++) {
            $arr[] = array_fill(0, $n, NULL);
        }

        $direcction = 'RIGHT';
        $currentLine = 0;
        $i = 0;
        $val = 1;
        $arr[$currentLine][$i] = $val;
        while (!$finished) {
            switch ($direcction) {
                case 'RIGHT':
                    $canGoRight = array_key_exists($i + 1, $arr[$currentLine]) && $arr[$currentLine][$i + 1] === NULL;
                    $canGoDown = array_key_exists($currentLine + 1, $arr) && $arr[$currentLine + 1][$i] === NULL;
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
                    $canGoDown = array_key_exists($currentLine + 1, $arr) && $arr[$currentLine + 1][$i] === NULL;
                    $canGoLeft = array_key_exists($i - 1, $arr[$currentLine]) && $arr[$currentLine][$i - 1] === NULL;
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
                    $canGoLeft = array_key_exists($i - 1, $arr[$currentLine]) && $arr[$currentLine][$i - 1] === NULL;
                    $canGoUp = array_key_exists($currentLine - 1, $arr) && $arr[$currentLine - 1][$i] === NULL;
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
                    $canGoUp = array_key_exists($currentLine - 1, $arr) && $arr[$currentLine - 1][$i] === NULL;
                    $canGoRight = array_key_exists($i + 1, $arr[$currentLine]) && $arr[$currentLine][$i + 1] === NULL;
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
