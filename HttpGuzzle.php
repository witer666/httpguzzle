<?php
/**
 *
 * Class HttpGuzzle
 * php guzzle库http请求封装类
 * @category    services
 * @package     http
 * @subpackage  guzzle
 * @author      linux_chen<linux_chen@163.com>
 * @version     2022/03/03 15:36:20
 * @copyright   Copyright (c) 2022 312 short knowledge. All Rights Reserved.
 */

require_once 'vendor/autoload.php';

class HttpGuzzle {

    /**
     * 请求最大超时时间6秒
     */
    const MAX_TIMEOUT           = 6.0;

    /**
     * json请求头
     */
    const HEADER_ACCEPT_JSON    = 'application/json';

    /**
     *
     * get请求
     *
     * @author  linux_chen<linux_chen@163.com>
     * @version 2022/03/03 15:36:20
     * @param   $strUrl string url地址
     * @param   $arrParam   array   请求参数
     * @param   $arrHeader  array   请求头信息
     * @param   $arrExtOption   array   请求选项信息
     * @return  array
     *
     */
    public static function get($strUrl, $arrParam = [], $arrHeader = [], $arrExtOption = []) {
        $arrRes         = self::_request($strUrl, HttpGuzzleMethod::GET, array_merge([
           'query'      => $arrParam,
           'headers'    => $arrHeader,
        ], $arrExtOption));

        return $arrRes;
    }

    /**
     *
     * post请求
     *
     * @author  linux_chen<linux_chen@163.com>
     * @version 2022/03/03 15:36:20
     * @param   $strUrl string url地址
     * @param   $arrParam   array   请求参数
     * @param   $arrHeader  array   请求头信息
     * @param   $arrExtOption   array   请求选项信息
     * @return  array
     *
     */
    public static function post($strUrl, $arrParam = [], $arrHeader = [], $arrExtOption = []) {
        $strParamKey        = 'form_params';
        if (isset($arrHeader['Accept']) && $arrHeader['Accept'] == self::HEADER_ACCEPT_JSON) {
            $strParamKey    = 'json';
        }
        $arrRes             = self::_request($strUrl, HttpGuzzleMethod::POST, array_merge([
            $strParamKey    => $arrParam,
            'headers'       => $arrHeader,
        ], $arrExtOption));

        return $arrRes;
    }

    /**
     *
     * put请求
     *
     * @author  linux_chen<linux_chen@163.com>
     * @version 2022/03/03 15:36:20
     * @param   $strUrl string url地址
     * @param   $arrParam   array   请求参数
     * @param   $arrHeader  array   请求头信息
     * @param   $arrExtOption   array   请求选项信息
     * @return  array
     *
     */
    public static function put($strUrl, $arrParam = [], $arrHeader = [], $arrExtOption = []) {
        $strParamKey        = 'form_params';
        if (isset($arrHeader['Accept']) && $arrHeader['Accept'] == self::HEADER_ACCEPT_JSON) {
            $strParamKey    = 'json';
        }
        $arrRes             = self::_request($strUrl, HttpGuzzleMethod::PUT, array_merge([
            $strParamKey    => $arrParam,
            'headers'       => $arrHeader,
        ], $arrExtOption));

        return $arrRes;
    }

    /**
     *
     * head请求
     *
     * @author  linux_chen<linux_chen@163.com>
     * @version 2022/03/03 15:36:20
     * @param   $strUrl string url地址
     * @return  array
     *
     */
    public static function head($strUrl) {
        $arrRes             = self::_request($strUrl, HttpGuzzleMethod::HEAD, []);

        return $arrRes;
    }

    /**
     *
     * delete请求
     *
     * @author  linux_chen<linux_chen@163.com>
     * @version 2022/03/03 15:36:20
     * @param   $strUrl string url地址
     * @param   $arrParam   array   请求参数
     * @param   $arrHeader  array   请求头信息
     * @param   $arrExtOption   array   请求选项信息
     * @return  array
     *
     */
    public static function delete($strUrl, $arrParam = [], $arrHeader = [], $arrExtOption = []) {
        $arrRes             = self::_request($strUrl, HttpGuzzleMethod::DELETE, array_merge([
            'query'         => $arrParam,
            'headers'       => $arrHeader,
        ], $arrExtOption));

        return $arrRes;
    }

    /**
     *
     * options请求
     *
     * @author  linux_chen<linux_chen@163.com>
     * @version 2022/03/03 15:36:20
     * @param   $strUrl string url地址
     * @param   $arrParam   array   请求参数
     * @param   $arrHeader  array   请求头信息
     * @param   $arrExtOption   array   请求选项信息
     * @return  array
     *
     */
    public static function options($strUrl, $arrParam = [], $arrHeader = [], $arrExtOption = []) {
        $arrRes             = self::_request($strUrl, HttpGuzzleMethod::OPTIONS, array_merge([
            'query'         => $arrParam,
            'headers'       => $arrHeader,
        ], $arrExtOption));

        return $arrRes;
    }

    /**
     *
     * 发送请求
     *
     * @author  linux_chen<linux_chen@163.com>
     * @version 2022/03/03 15:36:20
     * @param   $strUrl string url地址
     * @param   $strMethod  string  请求方式
     * @param   $arrOption   array   请求选项信息
     * @throws  \GuzzleHttp\Exception\RequestException
     * @throws  Exception
     * @return  array
     *
     */
    private static function _request($strUrl, $strMethod, $arrOption)
    {
        if (empty($strUrl) || !is_string($strUrl)) {
            return false;
        }

        $objClient          = new GuzzleHttp\Client([
            'timeout'       => self::MAX_TIMEOUT,
        ]);
        try {
            $objResponse    = $objClient->request($strMethod, $strUrl, $arrOption);
            $intCode        = $objResponse->getStatusCode();
            $intLength      = 0;
            if ($objResponse->hasHeader('Content-Length')) {
                $intLength  = $objResponse->getHeader('Content-Length');
            }

            $mixBody        = '';
            if ($strMethod != HttpGuzzleMethod::HEAD) {
                $mixBody        = $objResponse->getBody()->getContents();
                if ($objResponse->hasHeader('application/json')) {
                    $mixBody    = json_decode($mixBody, true);
                }
            }

        } catch(\GuzzleHttp\Exception\RequestException $exp) {
            return [
                'status'    => '-1',
                'code'      => $exp->getCode(),
                'msg'       => $exp->getMessage(),
            ];
        } catch(Exception $exp) {
            return [
                'status'    => '-2',
                'code'      => $exp->getCode(),
                'msg'       => $exp->getMessage(),
            ];
        }

        return [
            'status'    => 0,
            'code'      => $intCode,
            'length'    => $intLength,
            'body'      => $mixBody,
        ];
    }
}

/**
 * Class HttpGuzzleMethod ENUM
 */
class HttpGuzzleMethod {
    const GET       = 'GET';
    const POST      = 'POST';
    const PUT       = 'PUT';
    const HEAD      = 'HEAD';
    const DELETE    = 'DELETE';
    const OPTIONS   = 'OPTIONS';
}