<?php

namespace App\Components;

class ColorDictionary extends BaseDictionary
{
    public const RED = 0;
    public const GREEN = 1;
    public const BLUE = 2;
    public const YELLOW = 3;
    public const CYAN = 4;
    public const WHITE = 5;
    public function __construct()
    {
        parent::__construct();
        $this->list = [
            self::RED => 'Красный',
            self::GREEN => 'Зелёный',
            self::BLUE => 'Синий',
            self::YELLOW => 'Жёлтый',
            self::CYAN => 'Сине-зелёный',
            self::WHITE => 'Белый',
        ];
    }
    public function customSort()
    {
        return [
            $this->list[self::RED],
            $this->list[self::GREEN],
            $this->list[self::BLUE],
            $this->list[self::YELLOW],
            $this->list[self::CYAN],
            $this->list[self::WHITE],
        ];
    }
    public function getColor(int $color): string {
        switch ($color){
            case self::RED:
                return 'red';
            case self::GREEN:
                return 'green';
            case self::BLUE:
                return 'blue';
            case self::YELLOW:
                return 'yellow';
            case self::CYAN:
                return 'cyan';
            case self::WHITE:
                return 'white';
        }
        return 'white';
    }
}
