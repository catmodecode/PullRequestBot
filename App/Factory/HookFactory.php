<?php

namespace App\Factory;

use GitHook\Types\{Hook, HookType, PullRequest};
use App\Facade\Response;
use JsonException;

class HookFactory
{
    /**
     * @param mixed $load
     * 
     * @return HookType|null
     * @throws JsonException if $load is invalid json
     * @throws InvalidArgumentException if $load is not a string or an array
     */
    public static function makeHook(string $load): HookType
    {
        $hookClass = HookFactory::getHookType($load);
        return $hookClass == null
            ? null
            : new $hookClass($load);
    }

    /**
     * @param mixed $load
     * 
     * @return string|null
     * @throws JsonException if $load is invalid json
     */
    private static function getHookType(string $load): string
    {
        $payload = json_decode($load, true, 512, JSON_THROW_ON_ERROR);
     
        if (array_key_exists('hook', $payload)) {
            return Hook::class;
        }
        if (array_key_exists('pull_request', $payload)) {
            return PullRequest::class;
        }
        return null;
    }
}
