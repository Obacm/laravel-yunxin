<?php

namespace Obacm\YunXin;

use Obacm\YunXin\Exceptions\YunXinArgException;

/**
 * Class User
 * @package Obacm\YunXin
 */
class User extends AopClient
{
    const USER_CREATE_URL = 'user/create.action';

    const USER_UPDATE_URL = 'user/updateUinfo.action';

    const USER_REFRESH_TOKEN = 'user/refreshToken.action';

    const USER_GET_INFO = 'user/getUinfos.action';

    const GET_UINFOS_LIMIT = 200;

    const USER_NAME_LIMIT = 64;

    const USER_PROPS_LIMIT = 1024;

    const USER_ICON_LIMIT = 1024;

    const USER_TOKEN_LIMIT = 128;

    const USER_SIGN_LIMIT = 256;

    const USER_EMAIL_LIMIT = 64;

    const USER_BIRTH_LIMIT = 16;

    const USER_MOBILE_LIMIT = 32;

    const USER_GENDER_TYPES = [0, 1, 2];

    const USER_EX_LIMIT = 1024;

    /**
     * @param $accid
     * @param $name
     * @param $icon
     * @param $token
     * @param array $props
     * @param $sign
     * @param $email
     * @param $birth
     * @param $mobile
     * @param $gender
     * @param $ex
     * @throws YunXinArgException
     */
    private function verifyUserInfo(
        $accid,
        $name,
        $icon,
        $token,
        $props = [],
        $sign,
        $email,
        $birth,
        $mobile,
        $gender,
        $ex
    )
    {
        $gender = (int)($gender);
        $propsStr = \json_encode($props);

        if (!\is_string($accid)) {
            throw new YunXinArgException('accid 不合法');
        }

        if (\strlen($name) > self::USER_NAME_LIMIT) {
            throw new YunXinArgException('用户昵称最大长度' . self::USER_NAME_LIMIT . '字符');
        }

        if (\strlen($propsStr) > self::USER_PROPS_LIMIT) {
            throw new YunXinArgException('用户props最大长度' . self::USER_PROPS_LIMIT . '字符');
        }

        if (\strlen($icon) > self::USER_ICON_LIMIT) {
            throw new YunXinArgException('用户头像URL最大长度' . self::USER_ICON_LIMIT . '字符');
        }

        if (\strlen($token) > self::USER_TOKEN_LIMIT) {
            throw new YunXinArgException('用户token最大长度' . self::USER_TOKEN_LIMIT . '字符');
        }

        if (\strlen($sign) > self::USER_SIGN_LIMIT) {
            throw new YunXinArgException('用户sign最大长度' . self::USER_SIGN_LIMIT . '字符');
        }

        if (\strlen($email) > self::USER_EMAIL_LIMIT) {
            throw new YunXinArgException('用户邮箱最大长度' . self::USER_EMAIL_LIMIT . '字符');
        }

        if (\strlen($birth) > self::USER_BIRTH_LIMIT) {
            throw new YunXinArgException('用户生日最大长度' . self::USER_BIRTH_LIMIT . '字符');
        }

        if (\strlen($mobile) > self::USER_MOBILE_LIMIT) {
            throw new YunXinArgException('用户手机号最大长度' . self::USER_MOBILE_LIMIT . '字符');
        }

        if (!\in_array($gender, self::USER_GENDER_TYPES)) {
            throw new YunXinArgException('用户性别不合法');
        }

        if (\strlen($ex) > self::USER_EX_LIMIT) {
            throw new YunXinArgException('用户名片扩展最大长度' . self::USER_EX_LIMIT . '字符');
        }
    }

    /**
     * @param $accid
     * @param $name
     * @param string $icon
     * @param string $token
     * @param array $props
     * @param string $sign
     * @param string $email
     * @param string $birth
     * @param string $mobile
     * @param int $gender
     * @param string $ex
     * @return mixed
     * @throws YunXinArgException
     * @throws \Obacm\Yunxin\Exceptions\YunXinBusinessException
     * @throws \Obacm\Yunxin\Exceptions\YunXinInnerException
     * @throws \Obacm\Yunxin\Exceptions\YunXinNetworkException
     */
    public function create(
        $accid,
        $name,
        $icon = '',
        $token = '',
        $props = [],
        $sign = '',
        $email = '',
        $birth = '',
        $mobile = '',
        $gender = 0,
        $ex = ''
    )
    {
        $this->verifyUserInfo($accid, $name, $icon, $token, $props, $sign,
            $email, $birth, $mobile, $gender, $ex);

        $res = $this->sendRequest(self::USER_CREATE_URL, \array_filter([
            'accid' => $accid,
            'name' => $name,
            'icon' => $icon,
            'token' => $token,
            'props' => \json_encode($props),
            'sign' => $sign,
            'email' => $email,
            'birth' => $birth,
            'mobile' => $mobile,
            'gender' => $gender,
            'ex' => $ex,
        ]));

        return $res['info'];
    }

    /**
     * @param $accid
     * @param string $name
     * @param string $icon
     * @param string $sign
     * @param string $email
     * @param string $birth
     * @param string $mobile
     * @param string $gender
     * @param string $ex
     * @return mixed
     * @throws YunXinArgException
     * @throws \Obacm\Yunxin\Exceptions\YunXinBusinessException
     * @throws \Obacm\Yunxin\Exceptions\YunXinInnerException
     * @throws \Obacm\Yunxin\Exceptions\YunXinNetworkException
     */
    public function updateUserInfo(
        $accid,
        $name = '',
        $icon = '',
        $sign = '',
        $email = '',
        $birth = '',
        $mobile = '',
        $gender = '',
        $ex = ''
    ) {
        $this->verifyUserInfo($accid, $name, $icon, '', [], $sign,
            $email, $birth, $mobile, $gender, $ex);

        $res = $this->sendRequest(self::USER_UPDATE_URL, \array_filter([
            'accid' => $accid,
            'name' => $name,
            'icon' => $icon,
            'sign' => $sign,
            'email' => $email,
            'birth' => $birth,
            'mobile' => $mobile,
            'gender' => $gender,
            'ex' => $ex,
        ]));

        return $res['code'];
    }

    /**
     * @param array $accids
     * @return mixed
     * @throws YunXinArgException
     * @throws \Obacm\Yunxin\Exceptions\YunXinBusinessException
     * @throws \Obacm\Yunxin\Exceptions\YunXinInnerException
     * @throws \Obacm\Yunxin\Exceptions\YunXinNetworkException
     */
    public function getUserInfos(array $accids = [])
    {
        if (empty($accids)) {
            throw new YunXinArgException('查询用户不能为空');
        }

        if (count($accids) > self::GET_UINFOS_LIMIT) {
            throw new YunXinArgException('查询用户数量超过限制');
        }

        $res = $this->sendRequest(self::USER_GET_INFO, [
            'accids' => json_encode($accids)
        ]);

        return $res['uinfos'];
    }

    /**
     * @param $accid
     * @return mixed
     * @throws \Obacm\Yunxin\Exceptions\YunXinBusinessException
     * @throws \Obacm\Yunxin\Exceptions\YunXinInnerException
     * @throws \Obacm\Yunxin\Exceptions\YunXinNetworkException
     */
    public function refreshToken($accid)
    {
        $res = $this->sendRequest(self::USER_REFRESH_TOKEN, [
            'accid' => $accid
        ]);

        return $res['info'];
    }
}
