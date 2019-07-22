<?php

namespace Obacm\Yunxin;

use GuzzleHttp\Client;
use Obacm\Yunxin\Exceptions\YunXinInnerException;
use Obacm\Yunxin\Exceptions\YunXinNetworkException;
use Obacm\Yunxin\Exceptions\YunXinBusinessException;

/**
 * Class AopClient
 * @package Obacm\Yunxin
 */
class AopClient
{
    private $appKey;

    private $appSecret;

    public $nonceStr;

    public $curTime;

    public $checkSum;

    const TiME_OUT = 5;

    const BASE_URL = 'https://api.netease.im/nimserver/';

    const HEX_DIGITS = ['0', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n'];

    const BUSINESS_SUCCESS_CODE = 200;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->appKey = config('yunxin.app_key');

        $this->appSecret = config('yunxin.app_secret');
    }

    public function getCheckSum()
    {
        $this->setNonceStr();

        $this->setCurTime();

        $this->checkSum = \sha1($this->appSecret . $this->nonceStr . $this->curTime);
    }

    public function setCurTime()
    {
        $this->curTime = \time();
    }

    public function setNonceStr()
    {
        for ($i = 0; $i < 128; $i++) {
            $this->nonceStr .= self::HEX_DIGITS[\mt_rand(0, \count(self::HEX_DIGITS) - 1)];
        }
    }

    protected function sendRequest($uri, array $data = [])
    {
        $this->getCheckSum();

        $client = new Client([
            'base_uri' => self::BASE_URL,
            'timeout' => self::TiME_OUT,
        ]);

        $response = $client->request('POST', $uri, [
            'verify' => false, // 证书校验主动关闭
            'headers' => [
                'AppKey' => $this->appKey,
                'Nonce' => $this->nonceStr,
                'CurTime' => $this->curTime,
                'CheckSum' => $this->checkSum,
            ],
            'form_params' => $data
        ]);

        $code = $response->getStatusCode();
        $body = $response->getBody();

        if ($code !== 200) {
            throw new YunXinNetworkException('NetEase Network Error: ' . $body, $code);
        }

        $result = \json_decode((string)$body, true);

        if ($result && is_array($result) && $result['code'] === self::BUSINESS_SUCCESS_CODE) {
            return $result;
        } elseif ($result && \is_array($result)) {
            throw new YunXinBusinessException($result['desc'], $result['code']);
        } else {
            throw new YunXinInnerException('NetEase inner error: ' . $body);
        }
    }
}