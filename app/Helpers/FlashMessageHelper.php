<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.08.18
 * Time: 13:51
 */

namespace App\Helpers;


class FlashMessageHelper
{
    public static function success(string $message): void
    {
        session()->flash('success', $message);
    }

    public static function info(string $message): void
    {
        session()->flash('info', $message);
    }

    public static function warning(string $message): void
    {
        session()->flash('warning', $message);
    }

    public static function error(string $message): void
    {
        session()->flash('danger', $message);
    }

    public static function allTypes(): array
    {
        return [
            'success',
            'info',
            'warning',
            'danger',
        ];
    }
}