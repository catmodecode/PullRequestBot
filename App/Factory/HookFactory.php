<?php

namespace App\Factory;

use GitHook\Types\Hook;
use GitHook\Types\HookType;

class HookFactory
{
    public static function makeHook($load): HookType
    {
        $hookClass = HookFactory::getHookType($load);
        return $hookClass == null
            ? null
            : new $hookClass($load);
    }

    public static function getHookType($load): string
    {
        $payload = json_decode($load, true);

        if (array_key_exists('zen', $payload) || array_key_exists('hook', $payload)) {
            return Hook::class;
        }
        return null;
    }
}
