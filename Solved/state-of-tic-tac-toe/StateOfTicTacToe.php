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
        $this->verifyIfValid($board);

        $didSomeOneWin = $this->verifyWinner($board);
        if ($didSomeOneWin) return State::Win;

        $isGameFinished = $this->verifyIfFinished($board);
        if ($isGameFinished) {
            return State::Draw;
        }
        return State::Ongoing;
    }

    private function verifyIfFinished(array $board): bool
    {
        [$x, $o] = $this->getMoves($board);
        return ($x + $o) === 9;
    }


    private function verifyWinner(array $board): bool
    {
        $isThereAWinner = false;
        $winner = '';
        $winnerByHorizontalLine = $this->verifyHorizontalLines($board);
        if ($winnerByHorizontalLine !== NULL) {
            $winner = $winnerByHorizontalLine;
            $isThereAWinner = true;
        }

        $winnerByVerticalLine = $this->winnerByVerticalLines($board);
        if ($winnerByVerticalLine !== NULL) {
            $winner = $winnerByVerticalLine;
            $isThereAWinner = true;
        }

        $winnerByDiagonalLines = $this->verifyDiagonalLines($board);
        if ($winnerByDiagonalLines !== NULL) {
            $winner = $winnerByDiagonalLines;
            $isThereAWinner = true;
        }

        $this->verifyInconsistency($winner, $this->getMoves($board));

        return $isThereAWinner;
    }
    private function verifyInconsistency(string $winner, array $arr): void
    {
        [$xMoves, $oMoves] = $arr;
        if ($winner === "X" && $xMoves <= $oMoves) {
            throw new RuntimeException("Impossible board: wrong move count for winner");
        }
        if ($winner === "O" && !($xMoves === $oMoves)) {
            throw new RuntimeException("Impossible board: wrong move count for winner");
        }
    }

    private function getMoves($board): array
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
        return [$x, $o];
    }

    private function verifyDiagonalLines(array $board): string|NULL
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

        if ($x === 3) {
            return "X";
        }
        if ($o === 3) {
            return "O";
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

        if ($x === 3) {
            return "X";
        }
        if ($o === 3) {
            return "O";
        }

        return NULL;
    }
    private function winnerByVerticalLines(array $board): string|NULL
    {
        $winner = NULL;
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
                if ($winner === "O") {
                    throw new RuntimeException('Impossible board: game should have ended after the game was won');
                }
                $winner = "X";
            }

            if ($o === 3) {
                if ($winner === "X") {
                    throw new RuntimeException('Impossible board: game should have ended after the game was won');
                }
                $winner = "O";
            }
        }

        return $winner;
    }

    private function verifyHorizontalLines(array $board): string|NULL
    {
        $winner = NULL;
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
                if ($winner === "O") {
                    throw new RuntimeException('Impossible board: game should have ended after the game was won');
                }
                $winner = "X";
            }

            if ($o === 3) {
                if ($winner === "X") {
                    throw new RuntimeException('Impossible board: game should have ended after the game was won');
                }
                $winner = "O";
            }
        }
        return $winner;
    }

    private function verifyIfValid(array $board): void
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
            throw new RuntimeException('Wrong turn order: X went twice');
        }
        if ($diff < 0) {
            throw new RuntimeException('Wrong turn order: O started');
        }

        if ($x > 5 || $o > 4) {
            throw new RuntimeException('Exceeding the board');
        }
    }
}
