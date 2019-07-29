<?php

namespace Obacm\YunXin;

/**
 * Class Message
 * @package Obacm\YunXin\
 */
class Message extends AopClient
{
    const MSG_SEND_URL = 'msg/sendMsg.action';

    const MSG_CANCEL_URL = 'msg/recall.action';

    const MSG_TYPE_TEXT = 0;

    const MSG_TYPE_IMAGE = 1;

    const MSG_TYPE_VOICE = 2;

    const MSG_TYPE_VIDEO = 3;

    const MSG_TYPE_AUTO = 100;

    const MSG_OPE_USER = 0;

    const MSG_OPE_GROUP = 1;

    /**
     * @param $accidFrom
     * @param $ope
     * @param $accidTo
     * @param $type
     * @param $body
     * @param $pushcontent
     * @return mixed
     * @throws \Obacm\Yunxin\Exceptions\YunXinBusinessException
     * @throws \Obacm\Yunxin\Exceptions\YunXinInnerException
     * @throws \Obacm\Yunxin\Exceptions\YunXinNetworkException
     */
    public function send($accidFrom, $ope, $accidTo, $type, $body, $pushcontent)
    {
        $res = $this->sendRequest(self::MSG_SEND_URL, [
            'from' => $accidFrom,
            'ope' => $ope,
            'to' => $accidTo,
            'type' => $type,
            'body' => $body,
            'pushcontent' => $pushcontent,
        ]);

        return $res;
    }

    /**
     * @param $deleteMsgid
     * @param $timetag
     * @param $type
     * @param $from
     * @param $to
     * @param $msg
     * @param $ignoreTime
     * @param $pushContent
     * @param $payload
     * @return mixed
     * @throws \Obacm\Yunxin\Exceptions\YunXinBusinessException
     * @throws \Obacm\Yunxin\Exceptions\YunXinInnerException
     * @throws \Obacm\Yunxin\Exceptions\YunXinNetworkException
     */
    public function cancel($deleteMsgid, $timetag, $type, $from, $to, $msg, $ignoreTime, $pushContent, $payload)
    {
        $res = $this->sendRequest(self::MSG_CANCEL_URL, [
            'deleteMsgid' => $deleteMsgid,
            'timetag' => $timetag,
            'type' => $type,
            'from' => $from,
            'to' => $to,
            'msg' => $msg,
            'ignoreTime' => $ignoreTime,
            'pushcontent' => $pushContent,
            'payload' => $payload,
        ]);

        return $res;
    }
}