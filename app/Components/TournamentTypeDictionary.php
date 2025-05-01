<?php

namespace App\Components;

use Faker\Provider\Base;

class TournamentTypeDictionary extends BaseDictionary
{
    public const SWISS = 0;
    public const PLAY_OFF = 1;
    public const CIRCLE = 2;
    public function __construct()
    {
        parent::__construct();
        $this->list = [
            self::SWISS => 'Швейцарская',
            self::PLAY_OFF => 'Плей-офф',
            self::CIRCLE => 'Круговая',
        ];
    }

    public function customSort()
    {
        return [
            $this->list[self::SWISS],
            $this->list[self::PLAY_OFF],
            $this->list[self::CIRCLE],
        ];
    }

}
