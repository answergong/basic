<?php

namespace app\libraries;

class Tool
{
    /**
     * 正则检测简介是否符合要求
     *
     * @author   gongxiangzhu
     * @dateTime 2018/4/10 14:49
     *
     * @param  string $content 字符串
     *
     * @return mixed
     */
    public static function checkFilter($content)
    {
        //1、任意相同的单字符连续出现五次，除去 空白符！!？?。.-…—～－·~*※＊­_¯＿￣﹏﹋﹍﹉﹎﹊┄─
        //2、0-9的数字、一-十的汉字、壹-拾的大写汉字连续出现5次以上（含5次）。
        //3、含有http、qq、QQ、↑、↓、→、↑、→、↓、↗、\n 、</p>、 <p>、<br>、</br>。
        //4、含有老书、新书、推荐、求关注、收藏、书友、读者、交流群、群号、企鹅号、微信、微博、公众号。
        $data = ['老书','新书','推荐','求关注','收藏','书友','读者','交流群','群号','企鹅号','微信','微博','公众号','http','QQ','↑','↓','→','↑','→','↓','↗','\n','</p>','<p>','<br>','</br>'];
        foreach ($data as  $key=>$val){
            $bool = stripos($content, $val);
            if ($bool!==false) {
                var_dump('简介报错的原因是:'.$val);
                return false;
            }
        }
        if (preg_match('/[a-zA-Z]{5,}/',
            $content)) {
            return false;
        }
        $ignoreData=['？？？？？','﹏﹏﹏﹏﹏','～～～～～','—————','……………','-----','。。。。。','！！！！！'];
        foreach ($ignoreData as $key=>$value){
            $pos = stripos($content, $value);
            if ($pos!==false){
                $length = strlen($value);
                $begin = substr($content,0,$pos);
                $end = substr($content,$pos+$length);
                $strData=[$begin,$end];
//                var_dump($strData);die;
                foreach ($strData as $ke=>$val){
//                    var_dump($val);die;
                    if (preg_match('/((?:(?![\s！!？|\x{ff1f}\?。\.-…—～－·~*※＊­_¯＿￣﹏﹋﹍﹉﹎﹊┄─]).))\1{4,}|[0-9|\x{4E00}\x{4E8C}\x{4E09}\x{56DB}\x{4E94}\x{516D}\x{4E03}\x{516B}\x{4E5D}\x{5341}\x{58F9}\x{8D30}\x{53C1}\x{8086}\x{4f0d}\x{9646}\x{67d2}\x{634c}\x{7396}\x{62fe}]{5,}/iu',
                        $val)) {
                        return false;
                    }
                }

            }
        }


        return true;
    }
    public static function checkFilterOld($content)
    {
        //检测含有http
        if (stripos($content, 'http')) {
            return false;
        }
        if (preg_match('/(.)\1{3,}|[\s|0-9|a-z|\x{3002}\x{ff1f}\x{ff01}\x{ff0c}\x{3001}\x{ff1b}\x{ff1a}\x{201c}\x{201d}\x{2018}\x{2019}\x{ff08}\x{ff09}\x{300a}\x{300b}\x{3008}\x{3009}\x{3010}\x{3011}\x{300e}\x{300f}\x{300c}\x{300d}\x{fe43}\x{fe44}\x{3014}\x{3015}\x{2026}\x{2014}\x{ff5e}\x{fe4f}\x{ffe5}\!\@\#\$\%\^\&\*\(\)\~\,\.\?\[\]\-\=\_\+\:\"\;\{\}\/\<\>\\\\\']{4,}/iu',
            $content)) {
            return false;
        }
        //卡牌|卡片|手机|电话|几号|好友|换|[缺要有给]\s?[\d+|一二三四五六七八九十壹贰叁]|[\d一二三四五六七八九十壹贰叁]{2,}
        if (preg_match('/\x{5361}\x{724C}|\x{5361}\x{7247}|\x{624B}\x{673A}|\x{7535}\x{8BDD}|\x{51E0}\x{53F7}|\x{597D}\x{53CB}|\x{6362}|[\x{7F3A}\x{8981}\x{6709}\x{7ED9}]\s?[\d+|\x{4E00}\x{4E8C}\x{4E09}\x{56DB}\x{4E94}\x{516D}\x{4E03}\x{516B}\x{4E5D}\x{5341}\x{58F9}\x{8D30}\x{53C1}]|[\d\x{4E00}\x{4E8C}\x{4E09}\x{56DB}\x{4E94}\x{516D}\x{4E03}\x{516B}\x{4E5D}\x{5341}\x{58F9}\x{8D30}\x{53C1}]{2,}/iu',
            $content)) {
            return false;
        }
        return true;
    }
}

?>