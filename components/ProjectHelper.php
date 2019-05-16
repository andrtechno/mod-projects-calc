git add README.md<?php

namespace app\modules\projectscalc\components;
use Yii;
use yii\base\Exception;
use yii\helpers\Json;
use yii\httpclient\Client;

class ProjectHelper {

    public static function siteTypeList() {
        return array(
            0 => 'Сайт визитка',
            1 => 'Корпоративный сайт',
            2 => 'Интернет магазин',
            3 => 'Индивидуальный сайт',
            4 => 'Landing page',
        );
    }

    public static function siteTypeLists() {
        return array(
            0 => 'сайта визитки',
            1 => 'корпоративного сайта',
            2 => 'интернет магазина',
            3 => 'индивидуального сайта',
            4 => 'landing page',
        );
    }

    public static function priceFormat($price) {
        return number_format($price, 0, ' ', ' ');
    }


    public function  test(){

    }
    public static function privatBank() {

        $lang = Yii::$app->language;
        $curl = Yii::$app->curl;





        $client = new Client(['baseUrl' => 'https://api.privatbank.ua/p24api/pubinfo?coursid=5&json=true&exchange=true']);
        $response = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->send();

        if ($response->isOk) {
            $curr = [];
            foreach ($response->data as $k => $s) {
                $curr[$s['base_ccy']] = $s['sale'];
            }

            return $curr;
        } else {
            return false;
        }

    }

    public static function num2str($num) {
        $nul = 'ноль';
        $ten = array(
            array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
            array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
        );
        $a20 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
        $tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
        $hundred = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
        $unit = array(// Units
            array('копейка', 'копейки', 'копеек', 1),
            array('гривна', 'гривны', 'гривен', 0),
            array('тысяча', 'тысячи', 'тысяч', 1),
            array('миллион', 'миллиона', 'миллионов', 0),
            array('миллиард', 'милиарда', 'миллиардов', 0),
        );
        //
        list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
                if (!intval($v))
                    continue;
                $uk = sizeof($unit) - $uk - 1; // unit key
                $gender = $unit[$uk][3];
                list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2 > 1)
                    $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3];# 20-99
                else
                    $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3];# 10-19 | 1-9
                // units without rub & kop
                if ($uk > 1)
                    $out[] = self::morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
            } //foreach
        } else
            $out[] = $nul;
        $out[] = self::morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // uah
        //$out[] = $kop.' '.self::morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
    }

    /**
     * Склоняем словоформу
     * @ author runcore
     */
    public static function morph($n, $f1, $f2, $f5) {
        $n = abs(intval($n)) % 100;
        if ($n > 10 && $n < 20)
            return $f5;
        $n = $n % 10;
        if ($n > 1 && $n < 5)
            return $f2;
        if ($n == 1)
            return $f1;
        return $f5;
    }

}
