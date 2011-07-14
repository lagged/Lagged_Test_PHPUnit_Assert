## Lagged_Test_PHPUnit_Assert

A couple assertions I need. ;-)

Assertions:

 * `assertUrlsAreEqual()`

An example:

    <?php
    require_once 'PHPUnit/Autoload.php';
    require_once 'Lagged/Test/PHPUnit/Assert.php';

    class YourTest extends PHPUnit_Framework_TestCase
    {
        public function testWhichContainsUrls()
        {
            $expected = 'http://example.org/?bar=1&foo=2'; // this is the expected
            $actual   = 'http://example.org/?foo=2&bar=1'; // this is the actual url

            Lagged_Test_PHPUnit_Assert::assertUrlsAreEqual(
                $expected, $actual, "They are not equal!"
            );
        }
    }
