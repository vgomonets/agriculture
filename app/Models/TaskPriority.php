<?php

namespace App\Models;

class TaskPriority
{
    private static $priority = [
        'low' => ['title' => 'Низкий'],
        'normal' => ['title' => 'Средний'],
        'high' => ['title' => 'Высокий'],
    ];

    public static function all()
    {
        $res = [];
        foreach (static::$priority as $key => $val) {
            $res[$key] = (object) $val;
        }
        return $res;
    }
}
