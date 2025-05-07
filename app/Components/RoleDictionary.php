<?php

namespace App\Components;

class RoleDictionary extends BaseDictionary
{
    public const ADMIN = 2;
    public const JUDGE = 1;
    public const JUROR = 0;
    public const ADMIN_AVAILABLE_URLS = [
        // School routes
        '/school/index',
        '/school/create',
        '/school/store',
        '/school/show',
        '/school/edit',
        '/school/update',
        '/school/destroy',
        // Student routes
        '/student/index',
        '/student/create',
        '/student/store',
        '/student/show',
        '/student/edit',
        '/student/update',
        '/student/destroy',
        // Tournament routes
        '/tournament/index',
        '/tournament/create',
        '/tournament/store',
        '/tournament/show',
        '/tournament/edit',
        '/tournament/update',
        '/tournament/destroy',
        // Team routes
        '/team/index',
        '/team/create',
        '/team/store',
        '/team/show',
        '/team/edit',
        '/team/update',
        '/team/destroy',
        '/team/by-school',
        //Users routes
        '/user/index',
        '/user/create',
        '/user/store',
        '/user/show',
        '/user/edit',
        '/user/update',
        '/user/destroy',
        //Defences routes
        '/defence/index',
        '/defence/create',
        '/defence/store',
        '/defence/show',
        '/defence/edit',
        '/defence/update',
        '/defence/destroy',
        '/defence/act-defence',
        '/defence/add-team-participant',
        '/defence/delete-act-participant',
        '/defence/delete-defence-participant',
        '/defence/leaderboard',
        '/defence/score',
        '/defence/change-score',
        '/defence/leaderboard-update',
        '/draw/index/',
        '/draw/edit-score/',
        '/draw/conclude-score/'
    ];
    public const JUDGE_AVAILABLE_URLS = [
        // School routes
        '/school/index',
        '/school/show',
        // Student routes
        '/student/index',
        '/student/show',
        // Tournament routes
        '/tournament/index',
        '/tournament/show',
        // Team routes
        '/team/index',
        '/team/show',
        //Defences routes
        '/defence/index',
        '/defence/show',
    ];
    public const JUROR_AVAILABLE_URLS = [
        // School routes
        '/school/index',
        '/school/show',
        // Student routes
        '/student/index',
        '/student/show',
        // Tournament routes
        '/tournament/index',
        '/tournament/show',
        // Team routes
        '/team/index',
        '/team/show',
        //Defences routes
        '/defence/index',
        '/defence/show',
    ];
    public function __construct()
    {
        parent::__construct();
        $this->list = [
            self::ADMIN => 'Администратор',
            self::JUDGE => 'Судья',
            self::JUROR => 'Член жюри'
        ];
    }

    public function customSort()
    {
        return [
            $this->list[self::ADMIN],
            $this->list[self::JUDGE],
            $this->list[self::JUROR],
        ];
    }
    public static function getAvailableUrls($role){
        switch ($role){
            case self::ADMIN:
                return self::ADMIN_AVAILABLE_URLS;
            case self::JUDGE:
                return self::JUDGE_AVAILABLE_URLS;
            case self::JUROR:
                return self::JUROR_AVAILABLE_URLS;
            default:
                return [];
        }
    }
}
