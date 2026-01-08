<?php

declare(strict_types=1);

class Poker
{
    public array $bestHands = [];

    const CARD_VALUES = [
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        '10' => 10,
        'J' => 11,
        'Q' => 12,
        'K' => 13,
        'A' => 14,
    ];

    private array $possibleHands;

    public function __construct(array $hands)
    {
        $this->possibleHands = [
            'royal_flush' => fn(array $hand) => self::checkForRoyalFlush($hand),
            'straight_flush' => fn(array $hand) => self::checkStraightFlush($hand),
            'four_of_a_kind' => fn(array $hand) => self::checkOfAKind($hand, 4), // funciona
            'full_house' => fn(array $hand) => self::checkFullHouse($hand), // funciona
            'flush' => fn(array $hand) => self::checkFlush($hand),
            'straight' => fn(array $hand) => self::checkStraight($hand),
            'three_of_a_kind' => fn(array $hand) => self::checkOfAKind($hand, 3), // funciona
            'two_pair' => fn(array $hand) => self::checkTwoPair($hand), // funciona
            'one_pair' => fn(array $hand) => self::checkOfAKind($hand, 2), // funciona
            'high_card' => fn() => true,
        ];
        $this->bestHands = $this->getBestHands($hands);
    }

    private function getBestHands(array $hands): array
    {
        if (count($hands) === 1) {
            return $hands;
        }
        $bestHands = [];
        $orderedHands = [];

        foreach ($hands as $hand) {
            $orderedHands[] = $this->orderHand($hand);
        }

        while (empty($bestHands)) {
            foreach ($this->possibleHands as $key => $fn) {
                $haveTheHand = [];
                foreach ($orderedHands as $handData) {
                    if ($fn($handData[0])) {
                        $haveTheHand[] = $handData;
                    }
                }
                if (!empty($haveTheHand)) {
                    if (count($haveTheHand) > 1) {
                        $bestHands = $this->compareHands($haveTheHand, $key);

                        return $bestHands;
                    } else {
                        $bestHands[] = $haveTheHand[0]['old_hand'];
                        break 2;
                    }
                }
            }
        }
        return $bestHands;
    }

    private function compareHands(array $hands, $type)
    {
        return match ($type) {
            'royal_flush' => $this->everyoneWins($hands),
            'straight_flush' =>  $this->compareHighestCard($hands),
            'flush' =>  $this->compareHighestCard($hands),
            'straight' => $this->highCard($hands),
            'high_card' => $this->highCard($hands),
            'four_of_a_kind' => $this->findHighestGroup($hands, 4),
            'three_of_a_kind' => $this->findHighestGroup($hands, 3),
            'one_pair' => $this->findHighestGroup($hands, 2),
            'full_house' => $this->compareFull($hands),
            'two_pair' => $this->compareDoublePair($hands),
        };
    }

    private function compareFull(array $hands): array
    {
        $best = [];
        $bestRank = null;

        foreach ($hands as $hand) {
            $counts = [];
            foreach ($hand[0] as $card) {
                $counts[$card[1]] = ($counts[$card[1]] ?? 0) + 1;
            }

            $trio = null;
            $pair = null;

            foreach ($counts as $value => $count) {
                if ($count === 3) $trio = self::CARD_VALUES[$value];
                if ($count === 2) $pair = self::CARD_VALUES[$value];
            }

            if ($trio === null || $pair === null) continue;

            $rank = [$trio, $pair];

            if ($bestRank === null || $rank > $bestRank) {
                $bestRank = $rank;
                $best = [$hand['old_hand']];
            } elseif ($rank === $bestRank) {
                $best[] = $hand['old_hand'];
            }
        }

        return $best;
    }

    private function compareDoublePair(array $hands): array
    {
        $best = [];
        $bestRank = null;

        foreach ($hands as $hand) {
            $counts = [];
            foreach ($hand[0] as $card) {
                $counts[$card[1]] = ($counts[$card[1]] ?? 0) + 1;
            }

            $pairs = [];
            $kicker = null;

            foreach ($counts as $value => $count) {
                if ($count === 2) $pairs[] = self::CARD_VALUES[$value];
                if ($count === 1) $kicker = self::CARD_VALUES[$value];
            }

            if (count($pairs) !== 2) continue;

            rsort($pairs);
            $rank = [$pairs[0], $pairs[1], $kicker];

            if ($bestRank === null || $rank > $bestRank) {
                $bestRank = $rank;
                $best = [$hand['old_hand']];
            } elseif ($rank === $bestRank) {
                $best[] = $hand['old_hand'];
            }
        }

        return $best;
    }


    private function findHighestGroup(array $hands, int $amount): array
    {
        $bestHands = [];
        $bestValue = 0;

        foreach ($hands as $hand) {
            $cards = $hand[0];
            $counts = [];

            foreach ($cards as $card) {
                $value = $card[1];
                $counts[$value] = ($counts[$value] ?? 0) + 1;
            }

            foreach ($counts as $value => $count) {
                if ($count === $amount) {
                    $numericValue = self::CARD_VALUES[$value];

                    if ($numericValue > $bestValue) {
                        $bestValue = $numericValue;
                        $bestHands = [$hand['old_hand']];
                    } elseif ($numericValue === $bestValue) {
                        $bestHands[] = $hand['old_hand'];
                    }
                }
            }
        }

        if (count($bestHands) > 1) {
            return $this->highCard($hands);
        }

        return $bestHands;
    }


    private function highCard(array $hands): array
    {
        $remainingHands = $hands;

        for ($i = 0; $i < 5; $i++) {
            $bestCard = 0;
            $winners  = [];

            foreach ($remainingHands as $hand) {
                $cards = $hand[0];
                $oldHand = $hand['old_hand'];

                $cardValue = self::CARD_VALUES[$cards[$i][1]];

                if ($cardValue > $bestCard) {
                    $bestCard = $cardValue;
                    $winners = [$hand];
                } elseif ($cardValue === $bestCard) {
                    $winners[] = $hand;
                }
            }

            if (count($winners) === 1) {
                return [$winners[0]['old_hand']];
            }

            $remainingHands = $winners;
        }

        return array_column($remainingHands, 'old_hand');
    }


    private function compareHighestCard(array $hands): array
    {
        $winners  = [];
        $bestCard = 0;
        foreach ($hands as $hand) {
            $oldHand = $hand['old_hand'];
            $cards = $hand[0];

            $cardValue = self::CARD_VALUES[$cards[0][1]];

            if ($cardValue > $bestCard) {
                $bestCard = $cardValue;
                $winners = [$oldHand];
            } elseif ($bestCard === $cardValue) {
                $winners[] = $oldHand;
            }
        }
        return $winners;
    }

    private function everyoneWins(array $hands): array
    {
        $result = [];
        foreach ($hands as $hand) {
            $result[] = $hand["old_hand"];
        }
        return $result;
    }

    private function orderHand(string $hand): array
    {
        preg_match_all('/(10|[2-9JQKA])([CDHS])/', $hand, $matches, PREG_SET_ORDER);
        $order = self::CARD_VALUES;
        $cards = $matches;
        usort($cards, function ($a, $b) use ($order) {
            return $order[$b[1]] <=> $order[$a[1]];
        });
        return [
            0 => $cards,
            'old_hand' => $hand
        ];
    }
    private function checkForRoyalFlush(array $hand): bool
    {
        $flushStartsWithAnAce = $hand[0][1] === "A";
        return $this->checkFlush($hand) && $this->checkStraight($hand) && $flushStartsWithAnAce;
    }

    private function checkFullHouse(array $hand): bool
    {
        return $this->checkOfAKind($hand, 3) && $this->checkOfAKind($hand, 2);
    }

    private function checkFlush(array $hand): bool
    {
        $areAllSameType = true;
        $type = $hand[0][2];

        foreach ($hand as $card) {
            if ($type !== $card[2]) {
                $areAllSameType = false;
            }
        }
        return $areAllSameType;
    }

    private function checkOfAKind(array $hand, int $amount): bool
    {
        $counter = [];
        foreach ($hand as $card) {
            $counter[$card[1]] = $counter[$card[1]] + 1;
        }
        return in_array($amount, $counter, true);
    }

    private function checkStraightFlush(array $hand): bool
    {
        return $this->checkFlush($hand) && $this->checkStraight($hand);
    }
    private function checkStraight(array $hand): bool
    {
        $isStraight = true;
        // Ace Behaviour
        $card = $hand;

        $aceExeption = $card[0][1] == "A" && $card[1][1] == "5";
        if ($aceExeption) {
            array_shift($hand);
            array_pop($hand);
            $i = 1;
        } else {
            $i = 0;
        }


        for ($i; $i < count($hand) - 1; $i++) {

            $card = $hand[$i];
            $nextCard = $hand[$i + 1];
            $cardValue = self::CARD_VALUES[$card[1]];
            $nextCardValue = self::CARD_VALUES[$nextCard[1]];
            if (!($cardValue - 1 == $nextCardValue)) {
                $isStraight = false;
            }
        }
        return $isStraight;
    }
    private function checkTwoPair(array $hand): bool
    {
        $counter = [];
        foreach ($hand as $card) {
            $counter[$card[1]] = $counter[$card[1]] + 1;
        }

        $amount = 0;
        foreach ($counter as $value) {
            if ($value === 2) {
                $amount++;
            }
        }
        return $amount === 2;
    }
}
