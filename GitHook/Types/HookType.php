<?php

namespace GitHook\Types;

use GitHook\HookPayload;

interface HookType {
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return HookPayload
     */
    public function getPayload(): HookPayload;

    /**
     * Message for Telegram
     * 
     * @return string
     */
    public function getMessage():string;
    // public function getSender();
}