<?php

namespace TextRuApi;

use TextRuApi\Exception\WrongParameterException;
use TextRuApi\Exception\CurlRequestException;

class TextRuApi
{

    private $userkey;

    private static $allowed_options_get = ["exceptdomain", "excepturl", "visible", "copying", "callback"];

    private function __construct($userkey)
    {
        $this->userkey = $userkey;
    }

    public function userkey($userkey = null)
    {
        if (is_null($userkey)) return $this->userkey;

        $this->userkey = $userkey;

        return $this;
    }

    public static function add($userkey, $text, $options = [])
    {
        if ((empty($userkey)) || (empty($text))) throw new WrongParameterException("Required params is empty", 400123);

        if (!is_array($options)) throw new WrongParameterException("Options param must be array", 400124);

        foreach ($options as $key => $value) {
            if (!in_array($key, $this::$allowed_options_get)) throw new WrongParameterException("Unknown option " . $key . " provided", 400125);
        }

        $post_options = ["userkey" => $userkey, "text" => $text];
        if (!empty($options)) $post_options = array_merge($post_options, $options);

        return $this::sendCurl($post_options);

    }

    public static function sendCurl($postfields, $url = 'http://api.text.ru/post')
    {
        if (is_array($postfields)) $postfields = http_build_query($postfields, '', '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        $answer = curl_exec($ch);
        $errno = curl_errno($ch);

        $result = [
            "error"    => ["code" => null, "desc" => null],
            "text_uid" => null
        ];

        if ($errno) throw new CurlRequestException(curl_error($ch), $errno);

        $answer_decoded = json_decode($answer);

        if (isset($answer_decoded->error_code)) $result["error"]["code"] = $answer_decoded->error_code;
        if (isset($answer_decoded->error_desc)) $result["error"]["desc"] = $answer_decoded->error_desc;
        if (isset($answer_decoded->text_uid)) $result["text_uid"] = $answer_decoded->text_uid;

        return $result;

    }
}