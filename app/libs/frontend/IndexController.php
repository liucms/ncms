<?php
namespace app\libs\frontend;

use Api;

class IndexController {

    /**
     * 首页
     * @param  [type] $cid  [description]
     * @param  [type] $page [description]
     * @return [type]       [description]
     */
    public static function index() {

        $data['name'] = '昵称';
        $data['age'] = '26';
        $data['title'] = '地球村';
        $data['english'] = 'baidu.com';

        //$srt = Api::fun()->getXTea($data,'e');
        //echo $srt.PHP_EOL;
        //$srt = Api::fun()->getXTea($srt,'d');
        //echo $srt.PHP_EOL;

        //$srt = Api::fun()->getRSA('re',$data);
        //echo $srt.PHP_EOL;
        //$srt = Api::fun()->getRSA('ud',$srt);
        //echo $srt.PHP_EOL;
        //$srt = Api::fun()->getRSA('ue',$data);
        //echo $srt.PHP_EOL;
        //$srt = Api::fun()->getRSA('rd',$srt);
        //echo $srt.PHP_EOL;
        //$srt1 = Api::fun()->getRSA('rs',$data);
        //echo $srt1.PHP_EOL;
        //$srt = Api::fun()->getRSA('uv',$data,$srt1);
        //echo $srt.PHP_EOL;
        //$srt = Api::fun()->getRSA('tv',$data,$srt1,'alipay'); // 留空为公共密钥，alipay为第三次密钥
        //echo $srt.PHP_EOL;

        //echo Api::fun()->fixHtml('<div><p>百度一下</p>');

        Api::render('index', array('title' => '地球村'));
    }

}