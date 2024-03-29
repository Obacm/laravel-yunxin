<?php

namespace Obacm\YunXin;

/**
 * Class YunXin
 * @package Obacm\Yunxin
 */
class YunXin
{
    private $appKey;

    private $appSecrt;

    private $instances = [];

    public function __construct()
    {
        $this->appKey = \config('yunxin.app_key');

        $this->appSecret = \config('yunxin.app_secret');
    }

    /**
     * @return User
     */
    public function user()
    {
        $key = 'user';

        if (!\array_key_exists($key, $this->instances)) {
            $instance = new User();
            $this->instances[$key] = $instance;
        }

        return $this->instances[$key];
    }

    /**
     * @return Friend
     */
    public function friend()
    {
        $key = 'friend';

        if (!\array_key_exists($key, $this->instances)) {
            $instance = new Friend();
            $this->instances[$key] = $instance;
        }

        return $this->instances[$key];
    }

    public function message()
    {
        $key = 'message';

        if (!\array_key_exists($key, $this->instances)) {
            $instance = new Message();
            $this->instances[$key] = $instance;
        }

        return $this->instances[$key];
    }

    /**
     * 抄送消息验证检验码
     * @param $body
     * @param $curTime
     * @param $checksumPost
     * @return bool
     */
    public function isLegalChecksum($body, $curTime, $checksumPost)
    {
        return \sha1($this->appSecrt . \md5($body) . $curTime) === $checksumPost;
    }
}