<?php

namespace GitHook;

use InvalidArgumentException;

class HookPayload
{
    protected $payload;

    /**
     * @param json string|array $load
     * @throws JsonException if $load is string and it is a wrong json object
     * @throws InvalidArgumentException if $load is not a string or an array
     */
    public function __construct($load)
    {
        if (
            !is_string($load) &&
            !is_array($load) ||
            (is_string($load) && json_decode($load, true, 512, JSON_THROW_ON_ERROR) == null)
        ) {
            throw new InvalidArgumentException('load must be array or json string');
        }

        $payload = is_string($load)
            ? json_decode($load, true)
            : $load;
        foreach ($payload as &$value) {
            if (is_array($value) && HookPayload::isAssoc($value)) {
                $value = new HookPayload($value);
            }
        }
        $this->payload = $payload;
    }

    /**
     * @param string $key
     * @param string $default
     * 
     * @return string|HookPayload|array
     */
    public function get(string $key, $default = '')
    {
        return array_key_exists($key, $this->payload)
            ? $this->payload[$key]
            : $default;
    }

    private static function isAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
