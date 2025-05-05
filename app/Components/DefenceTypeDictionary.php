<?php

namespace App\Components;



class DefenceTypeDictionary extends BaseDictionary
{
    public const PERSONAL = 0;
    public const TEAM = 1;
    public function __construct()
    {
        parent::__construct();
        $this->list = [
            self::PERSONAL => 'Личная защита',
            self::TEAM => 'Командная защита',
        ];
    }

    public function customSort()
    {
        return [
            $this->list[self::PERSONAL],
            $this->list[self::TEAM],
        ];
    }
}
