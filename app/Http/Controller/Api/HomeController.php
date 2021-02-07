<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Http\Controller\Api;

use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Throwable;

/**
 * Class HomeController
 * @Controller()
 */
class HomeController
{
    /**
     * @RequestMapping("/api/home/index")
     * @throws Throwable
     */
    public function index(Request $request): Response
    {
        $signature = $request->get('signature', '');
        $timestamp = $request->get('timestamp', '');
        $nonce = $request->get('nonce', '');
        $echostr = $request->get('echostr', '');

        $token = 'fanli';
        //形成字符串  字典排序
        $array = [$timestamp,$nonce,$token];
        sort($array, SORT_STRING);
        //拼接成字符串  sha1加密   并于$signature比较
        $tmp = implode('', $array);
        $tmp = sha1($tmp);

        if ($tmp == $signature && $echostr) {
            context()->getResponse()->withContent($echostr);
        }
    }
}
