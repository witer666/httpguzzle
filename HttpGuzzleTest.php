<?php
include_once 'HttpGuzzle.php';

class HttpGuzzleTest {

    public static function get() {
        $strUrl     = 'http://localhost:8080/get.php';
        $arrParam   = ['a' => 'b' , 'c' => 'd'];
        $arrHeader  = [
            'Cookie'=> 'a=b;e=f',
        ];
        $arrExtOption = [
            'connect_timeout' => 1,
        ];
        $arrRes     = HttpGuzzle::get($strUrl, $arrParam, $arrHeader, $arrExtOption);
        return $arrRes;
    }

    public static function post() {
        $strUrl     = 'http://localhost:8080/post.php';
        $arrParam   = ['a' => 'p1' , 'c' => 'p2'];
        $arrHeader  = [
            'Cookie'=> 'a=b;e=f',
        ];
        $arrRes     = HttpGuzzle::post($strUrl, $arrParam, $arrHeader);
        return $arrRes;
    }

    public static function put() {
        $strUrl     = 'http://localhost:8080/put.php';
        $arrParam   = ['a' => 'put1' , 'c' => 'put2'];
        $arrHeader  = [
            'Cookie'=> 'a=b;e=f',
        ];
        $arrRes     = HttpGuzzle::put($strUrl, $arrParam, $arrHeader);
        return $arrRes;
    }

    public static function head() {
        $strUrl     = 'http://localhost:8080/head.php';
        $arrRes     = HttpGuzzle::head($strUrl);
        return $arrRes;
    }

    public static function delete() {
        $strUrl     = 'http://localhost:8080/delete.php';
        $arrParam   = ['a' => 'delete1' , 'c' => 'delete2'];
        $arrHeader  = [
            'Cookie'=> 'a=b;e=f',
        ];
        $arrRes     = HttpGuzzle::delete($strUrl, $arrParam, $arrHeader);
        return $arrRes;
    }

    public static function options() {
        $strUrl     = 'http://localhost:8080/options.php';
        $arrParam   = ['a' => 'options1' , 'c' => 'options2'];
        $arrHeader  = [
            'Cookie'=> 'a=b;e=f',
        ];
        $arrRes     = HttpGuzzle::options($strUrl, $arrParam, $arrHeader);
        return $arrRes;
    }
}
$arrRes = HttpGuzzleTest::get();
var_dump($arrRes);

$arrRes = HttpGuzzleTest::post();
var_dump($arrRes);

$arrRes = HttpGuzzleTest::put();
var_dump($arrRes);

$arrRes = HttpGuzzleTest::head();
var_dump($arrRes);

$arrRes = HttpGuzzleTest::options();
var_dump($arrRes);


