<?php

namespace TextRuApi\Tests;

require __DIR__ . "/../src/TextRuApi.php";
require __DIR__ . "/../src/Exception/CurlRequestException.php";
require __DIR__ . "/../src/Exception/WrongParameterException.php";

use TextRuApi\Exception\WrongParameterException;
use TextRuApi\TextRuApi;


class AddMethodTest extends \PHPUnit_Framework_TestCase
{
    public function test_empty_userkey_rise_exception()
    {
        $this->expectException(WrongParameterException::class);
        $this->expectExceptionCode(400123);
        TextRuApi::add("","Test text");
    }
}