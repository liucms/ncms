<?php
namespace app\libs\common;

class Tea {

    /**
     * 加密方法
     *
     * @param string $str    需要加密的内容
     * @param string $key    密钥
     * @param bool $toBase64  是否base64(最好true吧，比如cookie加密长度有限制的)
     * return string
     */
    public function XEncrypt($str, $key, $toBase64 = true) {
        if ($str == '') {
            return '';
        }
        $v = $this->_str2long($str, true);
        $k = $this->_str2long($key, false);
        if (count($k) < 4) {
            for ($i = count($k);$i < 4;$i++) {
                $k[$i] = 0;
            }
        }
        $n = count($v) - 1;
        $z = $v[$n];
        $y = $v[0];
        $delta = 0x9E3779B9;
        $q = floor(6 + 52 / ($n + 1));
        $sum = 0;
        while (0 < $q--) {
            $sum = $this->_int32($sum + $delta);
            $e = $sum >> 2 & 3;
            for ($p = 0;$p < $n;$p++) {
                $y = $v[$p + 1];
                $mx = $this->_int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ $this->_int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
                $z = $v[$p] = $this->_int32($v[$p] + $mx);
            }
            $y = $v[0];
            $mx = $this->_int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ $this->_int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
            $z = $v[$n] = $this->_int32($v[$n] + $mx);
        }
        if ($toBase64) {
            return base64_encode($this->_long2str($v, false));
        }
        return $this->_long2str($v, false);
    }

    /**
     * 解密方法
     *
     * @param string $str    加密后的内容
     * @param string $key    密钥
     * @param bool $toBase64
     * return string
     */
    public function XDecrypt($str, $key, $toBase64 = true) {
        if ($str == '') {
            return '';
        }
        $toBase64 && $str = base64_decode($str);
        $v = $this->_str2long($str, false);
        $k = $this->_str2long($key, false);
        if (count($k) < 4) {
            for ($i = count($k);$i < 4;$i++) {
                $k[$i] = 0;
            }
        }
        $n = count($v) - 1;
        $z = $v[$n];
        $y = $v[0];
        $delta = 0x9E3779B9;
        $q = floor(6 + 52 / ($n + 1));
        $sum = $this->_int32($q * $delta);
        while ($sum != 0) {
            $e = $sum >> 2 & 3;
            for ($p = $n;$p > 0;$p--) {
                $z = $v[$p - 1];
                $mx = $this->_int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ $this->_int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
                $y = $v[$p] = $this->_int32($v[$p] - $mx);
            }
            $z = $v[$n];
            $mx = $this->_int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ $this->_int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
            $y = $v[0] = $this->_int32($v[0] - $mx);
            $sum = $this->_int32($sum - $delta);
        }
        return $this->_long2str($v, true);
    }

    /**
     * 长整型转为字符串
     *
     * @param long $v
     * @param boolean $w
     * @return string
     */
    private function _long2str($v, $w) {
        $len = count($v);
        $n = ($len - 1) << 2;
        if ($w) {
            $m = $v[$len - 1];
            if (($m < $n - 3) || ($m > $n)) return false;
            $n = $m;
        }
        $s = array();
        for ($i = 0;$i < $len;$i++) {
            $s[$i] = pack("V", $v[$i]);
        }
        if ($w) {
            return substr(join('', $s), 0, $n);
        } else {
            return join('', $s);
        }
    }

    /**
     * 字符串转为长整型
     *
     * @param string $s
     * @param boolean $w
     * @return Ambigous <multitype:, number>
     */
    private function _str2long($s, $w) {
        $v = unpack("V*", $s . str_repeat("\0", (4 - strlen($s) % 4) & 3));
        $v = array_values($v);
        if ($w) {
            $v[count($v)] = strlen($s);
        }
        return $v;
    }

    private function _int32($n) {
        while ($n >= 2147483648) $n-= 4294967296;
        while ($n <= - 2147483649) $n+= 4294967296;
        return ( int )$n;
    }
}