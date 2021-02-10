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

use App\Bean\WeiXin;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;

/**
 * Class HomeController
 * @Controller()
 */
class HomeController
{
    /**
     * @Inject("weiXin")
     * @var WeiXin
     */
    private $weiXin;

    /**
     * @RequestMapping("/api/home/index")
     *
     * @return Response
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
            return context()->getResponse()->withContent($echostr);
        }
        return context()->getResponse()->withContent('fail');
    }

    /**
     * @RequestMapping("/api/home/get_token")
     *
     * @return Response
     */
    public function getAccessToken(): Response
    {
        return context()->getResponse()->withContent($this->weiXin->getAccessToken());
    }
}
