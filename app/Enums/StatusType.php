<?php declare(strict_types=1);

namespace App\Enums;
/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
enum StatusType: String
{
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';

    public static function toArray(): array {
        return [
            self::ACTIVE,
            self::INACTIVE,
        ];
    }
}
