<?php 
namespace app\libs\common;

use app;

class Common extends app\Engine {

    // XAES加密 返回JSON
    public function getXTea($data = 'str', $id = 'e') {
        $this->loader->register('getTea', 'app\libs\common\Tea');
        $srt = $this->getTea();
        switch ($id) {
            case 'e':
                return str_replace(array('+', '/', '='), array('-', '_', '~'),$this->encrypt(str_replace(array('+', '/', '='), array('-', '_', '~'),$srt->XEncrypt($data, md5($this->getKey()))), substr(md5($this->getKey()), 8, 16))); // 加密
                break;
            case 'd':
                return $srt->XDecrypt(str_replace(array('-', '_', '~'), array('+', '/', '='),$this->decrypt(str_replace(array('-', '_', '~'), array('+', '/', '='), $data), substr(md5($this->getKey()), 8, 16))), md5($this->getKey())); // 解密
                break;
            default:
                return 'AES Error: Data not';
        }
    }

    /**
     * @param string $string 需要加密的字符串
     * @param string $key 密钥
     * @return string
     */
    public function encrypt($string, $key) {
        // openssl_encrypt 加密不同Mcrypt，对秘钥长度要求，超出16加密结果不变
        $data = openssl_encrypt($string, 'AES-256-ECB', $key, OPENSSL_RAW_DATA);
        return base64_encode($data);
    }

    /**
     * @param string $string 需要解密的字符串
     * @param string $key 密钥
     * @return string
     */
    public function decrypt($string, $key) {
        $decrypted = openssl_decrypt(base64_decode($string), 'AES-256-ECB', $key, OPENSSL_RAW_DATA);
        return $decrypted;
    }

    // RSA 第三次公共证书
    public function getKey($name = 'public') {
        $config = $this->get('web.config');  // 密钥
        return trim(preg_replace('/[\r\n]/', '',$config[$name.'.third']));
    }

    // RSA 加密, 解密, 签名, 验签 返回JSON
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
                return $srt->privEncrypt($data); // 私钥加密
                break;
            case 'ud':
                return $srt->publicDecrypt($data); // 公钥解密
                break;
            case 'ue':
                return $srt->publicEncrypt($data); // 公钥加密
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