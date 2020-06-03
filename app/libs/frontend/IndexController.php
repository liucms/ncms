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

        //$data['name'] = '网红';
        //$data['age'] = '26';
        //$data['title'] = '我和你心连心';
        //$data['english'] = 'baidu.com';
        //$srt1 = Api::fun()->getRSA('re',$data);
        //echo $srt1.PHP_EOL;
        //$srt2 = Api::fun()->getRSA('ud',$srt1);
        //echo $srt2.PHP_EOL;
        //$srt1 = Api::fun()->getRSA('ue',$data);
        //echo $srt1.PHP_EOL;
        //$srt2 = Api::fun()->getRSA('rd',$srt1);
        //echo $srt2.PHP_EOL;
        //$srt3 = Api::fun()->getRSA('rs',$data);
        //echo $srt3.PHP_EOL;
        //$srt4 = Api::fun()->getRSA('uv',$data,$srt3);
        //echo $srt4.PHP_EOL;
        //$srt4 = Api::fun()->getRSA('tv',$data,$srt3,'alipay'); // 留空为公共密钥，alipay为第三次密钥
        //echo $srt4.PHP_EOL;

        //echo Api::fun()->fixHtml('<div><p>百度一下</p>');

        Api::render('index', array('title' => '测试接口'));
    }

}