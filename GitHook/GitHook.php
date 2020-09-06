<?php

namespace GitHook;

use App\Facade\Response;
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

    private function checkSignature($load): bool
    {
        $hookSecret = $this->secret;

        if ($hookSecret !== '') {
            if (!isset($_SERVER['HTTP_X_HUB_SIGNATURE'])) {
                Response::error("HTTP header 'X-Hub-Signature' is missing.");
            } elseif (!extension_loaded('hash')) {
                Response::error("Missing 'hash' extension to check the secret code validity.");
            }

            list($algo, $hash) = explode('=', $_SERVER['HTTP_X_HUB_SIGNATURE'], 2) + array('', '');
            if (!in_array($algo, hash_algos(), true)) {
                Response::error("Hash algorithm '$algo' is not supported.");
            }

            if (!hash_equals($hash, hash_hmac($algo, $load, $hookSecret))) {
                Response::error('Hook secret does not match.');
            }
        };
        return true;
    }

    /**
     * Load json from github webhook
     * 
     * @return void
     */
    public function getWebhook(): HookType
    {
        $load = file_get_contents('php://input');

        $this->checkSignature($load);
        $this->hook = HookFactory::makeHook($load);
        return $this->hook;
    }
}
