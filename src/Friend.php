<?php

namespace Obacm\YunXin;

/**
 * Class Friend
 * @package Obacm\YunXin\
 */
class Friend extends AopClient
{
    const FRIEND_GET_URL = 'friend/get.action';

    const FRIEND_ADD_URL = 'friend/add.action';

    const FRIEND_DELETE_URL = 'friend/delete.action';

    /**
     * @param $accid
     * @param $faccid
     * @param $type
     * @param null $msg
     * @return mixed
     * @throws \Obacm\Yunxin\Exceptions\YunXinBusinessException
     * @throws \Obacm\Yunxin\Exceptions\YunXinInnerException
     * @throws \Obacm\Yunxin\Exceptions\YunXinNetworkException
     */
    public function add($accid, $faccid, $type, $msg = null)
    {
        $res = $this->sendRequest(self::FRIEND_ADD_URL, \array_filter([
            'accid' => $accid,
            'faccid' => $faccid,
            'type' => $type
        ]));

        return $res['code'];
    }

    public function delete($accid, $faccid, $isDeleteAlias = true)
    {
        $res = $this->sendRequest(self::FRIEND_DELETE_URL, \array_filter([
            'accid' => $accid,
            'faccid' => $faccid,
            'isDeleteAlias' => $isDeleteAlias
        ]));

        return $res['code'];
    }
}