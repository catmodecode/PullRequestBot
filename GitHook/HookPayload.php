<?php

namespace GitHook;

use InvalidArgumentException;

class HookPayload
{
    protected $payload;

    /**
     * @param json string|array $load
     */
    public function __construct($load)
    {
        if(!is_string($load) && !is_array($load) || (is_string($load) && json_decode($load) == null)){
            throw new InvalidArgumentException('load must be array or string');
        }

        $payload = is_string($load)
            ? json_decode($load, true)
            : $load;
        foreach($payload as $key => &$value){
            if(is_array($value) && HookPayload::isAssoc($value)){
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
