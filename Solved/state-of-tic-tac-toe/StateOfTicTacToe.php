<?php

declare(strict_types=1);

enum State
{
    case Win;
    case Ongoing;
    case Draw;
}

class StateOfTicTacToe
{
    public function gameState(array $board): State
    {
        if (!$this->verifyIfValid($board)) {
            return throw new RuntimeException('Wrong turn order: O started');
        }

        $didSomeOneWin = $this->verifyWinner($board);
        if ($didSomeOneWin) return State::Win;

        $isGameFinished = $this->verifyIfFinished($board);
        if ($isGameFinished) {
            return State::Draw;
        } else {
            return State::Ongoing;
        }
    }

    private function verifyIfFinished(array $board): bool
    {
        $x = 0;
        $o = 0;
        for ($i = 0; $i < 3; $i++) {
            foreach ($board as $lines) {
                if ($lines[$i] === 'X') {
                    $x++;
                }
                if ($lines[$i] === 'O') {
                    $o++;
                }
            }
        }
        return ($x + $o) === 9;
    }


    private function verifyWinner(array $board): bool
    {
        $winnerByHorizontalLine = $this->verifyHorizontalLines($board);
        // var_dump('winnerByHorizontalLine');
        // var_dump($winnerByHorizontalLine);
        if ($winnerByHorizontalLine) return true;
        $winnerByVerticalLine = $this->winnerByVerticalLines($board);
        // var_dump('winnerByVerticalLine');
        // var_dump($winnerByHorizontalLine);
        if ($winnerByVerticalLine) return true;
        $winnerByDiagonalLines = $this->verifyDiagonalLines($board);
        // var_dump('winnerByDiagonal');
        // var_dump($winnerByDiagonalLines);
        if ($winnerByDiagonalLines) return true;
        return false;
    }

    private function verifyDiagonalLines(array $board): string|bool
    {
        $x = 0;
        $o = 0;
        // Primera Diagonal
        for ($i = 0; $i < 3; $i++) {
            $ejeX = $i;
            $ejeY = $i;
            $line = str_split($board[$ejeY])[$ejeX];
            if ($line === 'X') {
                $x++;
            }
            if ($line === 'O') {
                $o++;
            }
        }
        if ($x === 3 || $o === 3) {
            return true;
        }

        $x = 0;
        $o = 0;
        // Segunda Diagonal
        for ($i = 0; $i < 3; $i++) {
            $ejeX = $i;
            $ejeY = 2 - $i;
            $line = str_split($board[$ejeY])[$ejeX];

            if ($line === 'X') {
                $x++;
            }
            if ($line === 'O') {
                $o++;
            }
        }

        if ($x === 3 || $o === 3) {
            return true;
        }

        return false;
    }
    private function winnerByVerticalLines(array $board): bool
    {
        $xWon = false;
        $oWon = false;
        for ($i = 0; $i < 3; $i++) {
            $x = 0;
            $o = 0;
            foreach ($board as $lines) {
                if ($lines[$i] === 'X') {
                    $x++;
                }
                if ($lines[$i] === 'O') {
                    $o++;
                }
            }
            if ($x === 3) {
                $xWon = true;
            }
            if ($o === 3) {
                $oWon = true;
            }
        }

        if ($xWon && $oWon) {
            return throw new RuntimeException('Impossible board: game should have ended after the game was won');
        }
        if ($xWon || $oWon) {
            return true;
        }
        return false;
    }

    private function verifyHorizontalLines(array $board): string|bool
    {
        $xWon = false;
        $oWon = false;
        foreach ($board as $line) {
            $x = 0;
            $o = 0;
            $line = str_split($line);
            foreach ($line as $cell) {
                if ($cell === "X") {
                    $x++;
                }
                if ($cell === "O") {
                    $o++;
                }
            }
            if ($x === 3) {
                $xWon = true;
            }
            if ($o === 3) {
                $oWon = true;
            }
        }
        if ($xWon && $oWon) {
            return throw new RuntimeException('Impossible board: game should have ended after the game was won');
        }
        if ($xWon || $oWon) {
            return true;
        }
        return false;
    }

    private function verifyIfValid(array $board): bool
    {
        $x = 0;
        $o = 0;

        foreach ($board as $line) {
            foreach (str_split($line) as $cell) {
                if ($cell === 'X') {
                    $x++;
                } elseif ($cell === 'O') {
                    $o++;
                }
            }
        }


        $diff = $x - $o;

        if ($diff > 1) {
            return throw new RuntimeException('Wrong turn order: X went twice');
        }
        if ($diff < 0) {
            return throw new RuntimeException('Wrong turn order: O started');
        }

        // X nunca puede ir más de 1 jugada por delante de O
        // y O nunca puede tener más jugadas que X
        if ($diff < 0 || $diff > 1) {
            return false;
        }

        if ($x > 5 || $o > 4) {
            return false;
        }

        return true;
    }
}
