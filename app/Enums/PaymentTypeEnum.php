<?php declare(strict_types=1);

namespace App\Enums;
/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
enum PaymentTypeEnum: String
{
    const FLUTTERWAVE = 'flutterwave';
    const PAYSTACK = 'Paystack';

    public static function toArray(): array {
        return [
            self::FLUTTERWAVE,
            self::PAYSTACK,
        ];
    }
}
