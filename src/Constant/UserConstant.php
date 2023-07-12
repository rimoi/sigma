<?php

namespace App\Constant;

class UserConstant
{
    public const ADMIN     = "Administrateur";
    public const CLIENT      = "Client";

    public const ROLE_ADMIN     = "ROLE_ADMIN";
    public const ROLE_CLIENT      = "ROLE_CLIENT";

    private static $MAP = [
        self::ADMIN   => self::ADMIN,
        self::CLIENT    => self::CLIENT
    ];

    private static $MAP_STRING = [
        self::ADMIN   => self::ROLE_ADMIN,
        self::CLIENT    => self::ROLE_CLIENT
    ];

    public static function all(): array
    {
        return self::$MAP;
    }

    public static function asString($role): ?string
    {
        return self::$MAP_STRING[$role] ?? null;
    }

    public static function asStringInverse($role): ?string
    {
        $flipRole = array_flip(self::$MAP_STRING);

        return $flipRole[$role] ?? null;
    }
}