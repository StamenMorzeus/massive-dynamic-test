<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case ADMINISTRATOR = 'administrator';
    case SECRETARY = 'secretary';
    case CLIENT = 'client';

    /**
     * @return UserRoleEnum[]
     */
    public static function getAllRolesValue(): array
    {
        return [
            self::ADMINISTRATOR->value,
            self::SECRETARY->value,
            self::CLIENT->value
        ];
    }
}
