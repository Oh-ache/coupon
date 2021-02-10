<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Bean;

use Swlib\SaberGM;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * @Bean(name="weiXin")
 */
class WeiXin
{
    /**
     * 获取access_token
     *
     * @return string
     */
    public function getAccessToken(): string
    {
        $appId = env('APPID');
        $appSecert = env('APPSECERT');
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appId.'&secret='.$appSecert;
        $result = SaberGM::get($url)->getParsedJsonArray();
        return $result['access_token'];
    }

    /**
     * 微信自定义消息
     *
     * @return string
     */
    public function getMessage(string $str): string
    {
        $message = simplexml_load_string($str, 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($message->MsgType == 'text') {
            $content = $message->Content . time();
            $toUser = $message->FromUserName;
            $fromUser = $message->ToUserName;
            $msgType = 'text';
            $time = time();

            $tmp = '<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[%s]]></MsgType>
				<Content><![CDATA[%s]]></Content>
				</xml>';

            $info = sprintf($tmp, $toUser, $fromUser, $time, $msgType, $content);
            return $info;
        }
        return '';
    }
}
