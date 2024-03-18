<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use MillionMile\GetEnv\Env;

class MpmsgTest extends TestCase
{
    function composedata($data)
    {
        $newdata = array();
        foreach ($data as $key => $value) {
            $newdata[$key] = array("value" => $value);
        }
        return $newdata;
    }

    public function _testDemo()
    {
        $data = array("thing1" => "客户vip1", "character_string2" => "20231215001", "time3" => "2024年12月15日");
        $newdata = $this->composedata($data);
        $this->assertEquals(0, 0);
        return;
    }

    public function testSend()
    {
        try {
            Env::loadFile('.env');
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
        $app_id = Env::get('mp.app_id', 'default_value');   //获取[database]下的hostname字段
        $app_secret = Env::get('mp.app_secret','default_value');
        $mini_app_id = Env::get('mp.mini_app_id','default_value');
        $mp_openid = Env::get('mp.mpopenid');

        $tpl = new \Cqg21\Wechat\Template\MpTempMsg([
            'app_id' => $app_id,
            "app_secret" => $app_secret,
            // "access_token" => "78_N_ZTHRLRz37mq32TtE7k4AIpMGiVQqR850Q8GjpHjF3XuNrHtaNjG9fy9iXf71PjiK83OcmVeWEAjV5RAUw6co5f90outHUo6wmzxE0Hthj9CMkG4ogKc5xFXzQFRXiAAAQCI"
        ]);

        $message = Array("salesman"=>'小贾',
                          "name"=>'小园', 
                          "price"=>212.00,
                          "addtime"=>'2024-03-18 10:26:55',
                          "mpopenid"=>$mp_openid,
                          "order_sn"=>'2024031810254575',
                          "order_id"=>'45dd9kf+y7g5PKAJH1CsJ1syFZ9u1vI6IwJkz1tHoKS9'
        );
        $data = array("thing1" => sprintf("%s_%s_%s", $message['name'], $message['price'], $message['salesman']), 
                    "character_string2" => $message['order_sn'], 
                    "time3" => $message['addtime']);
        $mini = array("appid" => $mini_app_id, "pagepath" => "pages/order/detail?orderId=".$message['order_id']);

        $tpl->setTemplateId('Om7rmkKAMG2VhKFPc1hQ_PFYk3tjgtiFuZJdW3GIQ5M');
        $tpl->setTmpData($data);
        $tpl->setMiniprogramData($mini);
        var_dump($tpl->send($mp_openid, ''));
    }
}




/*
		{
           "touser":"5931342be598bb0e3c362cfb",
           "template_id":"Bs_GAEpveHgDbvS-tRMC2QmYRBg_SuVT3XsS-Y-JXzE", 
           "miniprogram":{
             "appid":"wxa015ac6468770f6f",
             "pagepath":"index?foo=bar"
           },
           "data":{
                   "keyword1":{
                       "value":"张三"
                   },
                   "keyword2": {
                       "value":"20231215001"
                   },
                   "keyword3": {
                       "value":"2024年3月12日"
                   }
           }
       }
*/
