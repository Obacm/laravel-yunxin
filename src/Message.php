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

    const MSG_NOTIFICATION_URL = 'msg/sendAttachMsg.action';

    const MSG_BATCH_URL = 'msg/sendBatchMsg.action';

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
     * @param string $pushcontent
     * @param string $ext
     * @return mixed
     * @throws Exceptions\YunXinBusinessException
     * @throws Exceptions\YunXinInnerException
     * @throws Exceptions\YunXinNetworkException
     */
    public function sendCustomMsg($accidFrom, $ope, $accidTo, $type, $body, $pushcontent = '', $ext = '')
    {
        $res = $this->sendRequest(self::MSG_SEND_URL, [
            'from' => $accidFrom,
            'ope' => $ope,
            'to' => $accidTo,
            'type' => $type,
            'body' => $body,
            'pushcontent' => $pushcontent,
            'ext' => $ext,
        ]);

        return $res;
    }

    /**
     * @param $from
     * @param $msgType
     * @param $to
     * @param $attach
     * @param string $pushContent
     * @param string $ext
     * @return mixed
     * @throws Exceptions\YunXinBusinessException
     * @throws Exceptions\YunXinInnerException
     * @throws Exceptions\YunXinNetworkException
     */
    public function sendAttachMsg($from, $msgType, $to, $attach, $pushContent = '', $ext = '')
    {
        $res = $this->sendRequest(self::MSG_NOTIFICATION_URL, [
            'from' => $from,
            'msgtype' => $msgType,
            'to' => $to,
            'attach' => $attach,
            'pushcontent' => $pushContent,
            'ext' => $ext,
        ]);

        return $res;
    }

    /**
     * @param $accidFrom
     * @param array $accidsTo
     * @param $type
     * @param $body
     * @param string $pushContent
     * @param string $ext
     * @return mixed
     * @throws Exceptions\YunXinBusinessException
     * @throws Exceptions\YunXinInnerException
     * @throws Exceptions\YunXinNetworkException
     */
    public function sendBatchMsg($accidFrom, array $accidsTo, $type, $body, $pushContent = '', $ext = '')
    {
        $res = $this->sendRequest(self::MSG_BATCH_URL, [
            'fromAccid' => $accidFrom,
            'toAccids' => json_encode($accidsTo),
            'type' => $type,
            'body' => $body,
            'pushcontent' => $pushContent,
            'ext' => $ext,
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
    public function cancelMsg($deleteMsgid, $timetag, $type, $from, $to, $msg, $ignoreTime, $pushContent, $payload)
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