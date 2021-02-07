<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

function user_func(): string
{
    return 'hello';
}

/**
 * 微信官方提供的验签方法
 *
 * @param $signature
 * @param $timestamp
 * @param $nonce
 * @return bool
 */
function checkSignature($signature, $timestamp, $nonce)
{
    $token = 'fanli';
    $tmpArr = [$token, $timestamp, $nonce];
    sort($tmpArr, SORT_STRING);
    $tmpStr = implode($tmpArr);
    $tmpStr = sha1($tmpStr);

    if ($tmpStr == $signature) {
        return true;
    } else {
        return false;
    }
}
