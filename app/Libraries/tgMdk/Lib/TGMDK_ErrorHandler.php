<?php

Namespace App\Libraries\tgMdk\Lib;

/**
 * エラーハンドリング処理。
 * @param int $errno
 * @param string $errstr
 * @param string $errfile
 * @param int $errline
 * @throws ErrorException
 */

use ErrorException;

trait TGMDK_ErrorHandler {

    function error_handler($errno, $errstr, $errfile, $errline) {

        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
}

