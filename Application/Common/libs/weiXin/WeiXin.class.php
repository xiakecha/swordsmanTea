<?php
/**
 * Created by PhpStorm.
 * User: wsw
 * Date: 2015/9/23
 * Time: 14:13
 */
namespace Common\Libs\weiXin;

class WeiXin {

    protected $token = "tQksNZs8rQfscMzVDvZqrFsmCZSCCskC";
    protected $appId = "wx01881e098d8c9878";
    protected $appSecret = "d4d937a8a4ffa6370988384a2a9a77a2";

    /**
     * 判断是否为微信header
     * @return bool
     */
    public function isWeiXin() {
        $agent = $_SERVER["HTTP_USER_AGENT"];
        $isWeiXin = preg_match('/MicroMessenger/',$agent);

        return $isWeiXin ? true : false;
    }

    /**
     * 获取微信认证包数据
     * @return array
     */
    public function getWeiXinSignPackage() {
            require_once "jssdk.php";
            $jsSdk = new \JSSDK($this->appId, $this->appSecret);
            $signPackage = $jsSdk->GetSignPackage();

            return $signPackage;
    }
}
