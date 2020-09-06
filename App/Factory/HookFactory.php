<?php

namespace App\Factory;

use GitHook\Types\{Hook, HookType, PullRequest};

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

        if (array_key_exists('hook', $payload)) {
            return Hook::class;
        }
        if (array_key_exists('pull_request', $payload)) {
            return PullRequest::class;
        }
        return null;
    }
}
