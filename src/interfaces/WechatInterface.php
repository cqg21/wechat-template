<?php

namespace Cqg21\Wechat\Template\interfaces;

interface WechatInterface
{
    public function send($openId,$formId);

    public function getAccessToken();

    //发送模板消息
    const TEMPLATE_MESSAGE_SEND = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send';
    const MP_TEMPLATE_MESSAGE_SEND = 'https://api.weixin.qq.com/cgi-bin/message/template/send';
    // https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=ACCESS_TOKEN
    //获取小程序全局唯一后台接口调用凭据
    const ACCESS_TOKEN          = 'https://api.weixin.qq.com/cgi-bin/token';
    //https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx48ab18c0e4f8731b&secret=792c1b5a4e6fd10e266aa63973d19c14
}