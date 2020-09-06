<?php

namespace GitHook;

use App\Factory\HookFactory;
use GitHook\Types\Hook;
use GitHook\Types\HookType;

/**
 * Base class to work with github webhooks
 * Call getWebhook to get webhook payload
 */
class GitHook
{
    private string $secret;
    private HookType $hook;

    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    /**
     * Load json from github webhook
     * 
     * @return void
     */
    public function getWebhook(): HookType
    {
        $this->hook = HookFactory::makeHook(file_get_contents('php://input'));
        // new Hook(file_get_contents('php://input'));
        return $this->hook;
    }
}
