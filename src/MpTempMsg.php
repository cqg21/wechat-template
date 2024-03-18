<?php

namespace Cqg21\Wechat\Template;

use Cqg21\Wechat\Template\tools\Tools;
use Cqg21\Wechat\Template\Message;

class MpTempMsg extends Message
{
    /**
     * 发送模板消息
     * @param $openId
     * @param $formId
     * @return array
     */
    public function send($openId, $formId)
    {
        // TODO: Implement send() method.
        try {
            $access_token = $this->getAccessToken();
            $params = [
                'touser'        => $openId,
                'template_id'   => $this->template_id,
                'data' => $this->template_data, 
                'miniprogram' => $this->miniporgram_data,
            ];
            // print_r(json_encode($params));
            $header = array();
            // $header[] = 'Authorization:'.$tmp;
            $header[] = 'Accept:application/json';
            $header[] = 'Content-Type:application/json;charset=utf-8';
            $result = Tools::request_post(parent::MP_TEMPLATE_MESSAGE_SEND . '?access_token=' . $access_token, json_encode($params), $header);
            // $result = Tools::request_post(parent::MP_TEMPLATE_MESSAGE_SEND . '?access_token=' . $access_token, array_filter($params), $header);
            if (!$result || $result['errcode'] != 0) {
                throw new \Exception($result['errmsg']);
            }
            return Tools::result(true, 'SUCCESS');
        } catch (\Exception $e) {
            return Tools::result(false, $e->getMessage());
        }
    }
}
