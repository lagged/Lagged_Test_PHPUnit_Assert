<?php
class AssertTestCase extends PHPUnit_Framework_TestCase
{
    public function testUrl()
    {
        $url1 = 'http://example.org/foo/?bar=1&foo=2';
        $url2 = 'http://example.org/foo/?foo=2&bar=1';

        Lagged_Test_PHPUnit_Assert::assertUrlsAreEqual($url1, $url2);
    }
}
