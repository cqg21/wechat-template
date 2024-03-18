<?php

namespace Cqg21\Wechat\Template;

use Cqg21\Wechat\Template\interfaces\WechatInterface;
use Cqg21\Wechat\Template\tools\Tools;

abstract class Message implements WechatInterface
{
    /**
     * 配置
     * @var array
     */
    protected $config       = [];

    protected $appId        = null;
    protected $appSecret    = null;

    /**
     * 模板id
     * @var null
     */
    protected $template_id  = null;

    /**
     * 模板数据
     * @var null
     */
    protected $template_data  = null;


    protected $miniporgram_data = null;

    /**
     * 模板需要放大的关键词
     * @var null
     */
    protected $emphasis_keyword  = '';

    /**
     * 点击模板卡片后的跳转页面
     * @var null
     */
    protected $page  = '';

    protected $access_token = "";

    public function __construct($config = [])
    {
        $this->config   = $config;
        $this->appId    = $config['app_id'] ?? null;
        $this->appSecret = $config['app_secret'] ?? null;
        $this->access_token = $config['access_token'] ?? null;
    }

    public function setAccessToken($token)
    {
        $this->access_token = $token;
    }

    private function composedata($data)
    {
        $newdata = array();
        foreach ($data as $key => $value) {
            $newdata[$key] = array("value" => $value);
        }
        return $newdata;
    }

    public function setMiniprogramData($data)
    {
        $this->miniporgram_data =  $data;
    }

    public function setTmpData($data = null)
    {
        $newdata = $this->composedata($data);
        $this->template_data = $newdata;
    }

    public function setData($data = null)
    {
        if ($data) {
            $key = 1;
            foreach ($data as $value) {
                $this->template_data['keyword' . $key] = [
                    'value' => $value
                ];
                $key++;
            }
        }
    }

    public function setEmphasisKeyword($keyword = '')
    {
        $this->emphasis_keyword = $keyword;
    }

    public function setTemplateId($tpl_id = null)
    {
        $this->template_id = $tpl_id;
    }

    public function setPage($page = '')
    {
        $this->page = $page;
    }

    public function getAccessToken()
    {
        // TODO: Implement getAccessToken() method.
        if ($this->access_token) {
            return $this->access_token;
        }
        return $this->getAccessTokenFromWechat();
    }

    public function getAccessTokenFromWechat()
    {
        $params = [
            'grant_type'    => 'client_credential',
            'appid'         => $this->appId,
            'secret'        => $this->appSecret
        ];
        $result = Tools::request_get(self::ACCESS_TOKEN, $params);
        if (!$result || (isset($result['errcode']) && $result['errcode'] != 0)) {
            throw new \Exception('获取调用凭据（access_token）失败【' . $result['errcode'] . '】：' . $result['errmsg']);
        }
        return $result['access_token'];
    }
}
