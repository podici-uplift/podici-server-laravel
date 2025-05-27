<?php

namespace App\Enums\Review;

enum ReviewRating: int
{
    case One = 1;
    case Two = 2;
    case Three = 3;
    case Four = 4;
    case Five = 5;
    case Six = 6;
    case Seven = 7;
    case Eight = 8;
    case Nine = 9;
    case Ten = 10;

    public function label(): string
    {
        return match ($this) {
            self::One => 'Terrible',
            self::Two => 'Very Bad',
            self::Three => 'Bad',
            self::Four => 'Poor',
            self::Five => 'Average',
            self::Six => 'Slightly Above Average',
            self::Seven => 'Good',
            self::Eight => 'Very Good',
            self::Nine => 'Excellent',
            self::Ten => 'Perfect',
        };
    }
}
