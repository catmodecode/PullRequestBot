<?php

namespace GitHook\Exceptions;

use Exception;

/*
 * Throw if HTTP header 'X-Hub-Signature' is missing.
 */
Class SignatureException extends Exception
{
    //...
}