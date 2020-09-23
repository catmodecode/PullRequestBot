<?php

namespace GitHook;

use App\Facade\Response;
use App\Factory\HookFactory;
use GitHook\Types\HookType;
use GitHook\Exceptions\{
    SignatureException,
    ExtensionMissingException,
    UnsupportedHashAlgoException,
    HookMismatchException
};

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
     * @param mixed $load
     * 
     * @return bool
     * 
     * returns true or throws one of exceptions below
     * 
     * @throws JsonException if incoming input is invalid json
     * @throws SignatureException if 'X-Hub-Signature' is missing
     * @throws ExtensionMissingException if 'hash' extension is missing
     * @throws UnsupportedHashAlgoException if 'hash algorithm is not supported
     * @throws HookMismatchException if stored and github hooks are mismatch
     */
    private function checkSignature($load): bool
    {
        $hookSecret = $this->secret;

        if ($hookSecret !== '') {
            if (!isset($_SERVER['HTTP_X_HUB_SIGNATURE'])) {
                throw new SignatureException("HTTP header 'X-Hub-Signature' is missing.");
            } elseif (!extension_loaded('hash')) {
                throw new ExtensionMissingException(
                    "Missing 'hash' extension to check the secret code validity."
                );
            }

            list($algo, $hash) = explode('=', $_SERVER['HTTP_X_HUB_SIGNATURE'], 2) + array('', '');
            if (!in_array($algo, hash_algos(), true)) {
                throw new UnsupportedHashAlgoException("Hash algorithm '$algo' is not supported.");
            }

            if (!hash_equals($hash, hash_hmac($algo, $load, $hookSecret))) {
                throw new HookMismatchException('Hook secret does not match.');
            }
        };
        return true;
    }

    /**
     * Load json from github webhook
     * 
     * @return void
     * 
     * @throws JsonException if incoming input is invalid json
     * @throws SignatureException if 'X-Hub-Signature' is missing
     * @throws ExtensionMissingException if 'hash' extension is missing
     * @throws UnsupportedHashAlgoException if 'hash algorithm is not supported
     * @throws HookMismatchException if stored and github hooks are mismatch
     */
    public function getWebhook(): HookType
    {
        $load = file_get_contents('php://input');

        $this->checkSignature($load);
        $this->hook = HookFactory::makeHook($load);
        return $this->hook;
    }
}
