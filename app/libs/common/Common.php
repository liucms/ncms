<?php 
namespace app\libs\common;

use app;

class Common extends app\Engine {

    // RSA 第三次公共证书
    public function getKey($name = 'public') {
        $config = $this->get('web.config');  // 密钥
        return trim(preg_replace('/[\r\n]/', '',$config[$name.'.third']));
    }

    // RSA加密
    public function getRSA($id = 're', $data, $sign = false, $third = false) {
        $config = $this->get('web.config');  // 密钥
        $this->loader->register('getRsaSrt', 'app\libs\common\Rsa',array(
            $config['public.third'],
            $config['private'],
            (empty($third)?$this->getKey():$this->getKey($third)),
        ));
        $srt = $this->getRsaSrt();
        switch ($id) {
            case 're':
                return $srt->privEncrypt(json_encode($data, JSON_UNESCAPED_UNICODE)); // 私钥加密
                break;
            case 'ud':
                return $srt->publicDecrypt($data); // 公钥解密
                break;
            case 'ue':
                return $srt->publicEncrypt(json_encode($data, JSON_UNESCAPED_UNICODE)); // 公钥加密
                break;
            case 'rd':
                return $srt->privDecrypt($data); // 私钥解密
                break;
            case 'rs':
                return $srt->privSign($data); // 私钥签名
                break;
            case 'uv':
                return $srt->publicVerifySign($data, $sign); // 公钥验证
                break;
            case 'tv':
                return $srt->publicVerifySignThird($data, $sign); // 第三方公钥验证
                break;
            default:
                return 'RSA Error: Data not';
        }
    }

    // 修复 HTML 标签闭合问题（检查并补全）
    public function fixHtml($srt){
        $srt = preg_replace('/<[^>]*$/','',$srt);
        preg_match_all('/<([a-z]+)(?: .*)?(?<![\/|\/ ])>/iU', $srt, $result);
        if($result){
            $opentags = $result[1];
            preg_match_all('/<\/([a-z]+)>/iU', $srt, $result);
            if($result){
                $closetags = $result[1];
                $len_opened = count($opentags);
                if (count($closetags) == $len_opened) {
                    return $srt;  //没有未关闭标签
                }
                $opentags = array_reverse($opentags);
                $sc = array('br','input','img','hr','meta','link');  //跳过这些标签
                for ($i=0; $i < $len_opened; $i++) {
                    $ot = strtolower($opentags[$i]);
                    if (!in_array($opentags[$i], $closetags) && !in_array($ot,$sc)) {
                        $srt .= '</'.$opentags[$i].'>';  //补齐标签
                    } else {
                        unset($closetags[array_search($opentags[$i], $closetags)]);
                    }
                }
            }
        }
        return $srt;
    }

}