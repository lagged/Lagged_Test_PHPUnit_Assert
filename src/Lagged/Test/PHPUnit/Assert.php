<?php
/**
 * +-----------------------------------------------------------------------+
 * | Copyright (c) 2011, Till Klampaeckel                                  |
 * | All rights reserved.                                                  |
 * |                                                                       |
 * | Redistribution and use in source and binary forms, with or without    |
 * | modification, are permitted provided that the following conditions    |
 * | are met:                                                              |
 * |                                                                       |
 * | o Redistributions of source code must retain the above copyright      |
 * |   notice, this list of conditions and the following disclaimer.       |
 * | o Redistributions in binary form must reproduce the above copyright   |
 * |   notice, this list of conditions and the following disclaimer in the |
 * |   documentation and/or other materials provided with the distribution.|
 * | o The names of the authors may not be used to endorse or promote      |
 * |   products derived from this software without specific prior written  |
 * |   permission.                                                         |
 * |                                                                       |
 * | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   |
 * | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     |
 * | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR |
 * | A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT  |
 * | OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, |
 * | SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT      |
 * | LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, |
 * | DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY |
 * | THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT   |
 * | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE |
 * | OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.  |
 * |                                                                       |
 * +-----------------------------------------------------------------------+
 * | Author: Till Klampaeckel <till@php.net>                               |
 * +-----------------------------------------------------------------------+
 *
 * PHP version 5
 *
 * @category Testing
 * @package  Lagged_Test_PHPUnit_Assert
 * @author   Till Klampaeckel <till@php.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @version  GIT: $Id$
 * @link     http://github.com/lagged/Lagged_Test_PHPUnit_Assert
 */

/**
 * @ignore
 */
require_once 'PHPUnit/Framework/Assert.php';

/**
 * A couple useful assertions.
 *
 * @category Testing
 * @package  Lagged_Test_PHPUnit_Assert
 * @author   Till Klampaeckel <till@php.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @version  Release: @package_version@
 * @link     http://github.com/lagged/Lagged_Test_PHPUnit_Assert
 */
class Lagged_Test_PHPUnit_Assert extends PHPUnit_Framework_Assert
{
    /**
     * Compare two URLs with another.
     *
     * E.g. http://example.org?foo=bar&foo1=bar should equal http://example.org?foo1=bar&foo=bar
     *
     * @param string $expected A URL
     * @param string $actual   Another URL
     * @param string $message  To be displayed when it's not equal.
     *
     * @return void
     *
     * @uses PHPUnit_Util_InvalidArgumentHelper
     * @uses self::assertEquals()
     * @uses self::assertArrayHasKey()
     * @uses self::
     */
    public static function assertUrlsAreEqual($expected, $actual, $message = '')
    {
        $expectedParsed = parse_url($expected);
        if ($expectedParsed === false
            || (is_array($expectedParsed) && empty($expectedParsed))
        ) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(
              1, 'Must a URL'
            );
        }

        $actualParsed = parse_url($actual);
        if ($actualParsed === false
            || (is_array($actualParsed) && empty($actualParsed))
        ) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(
                2, 'Must be a URL'
            );
        }

        /**
         * @desc Make sure both arrays contain the same number of elements before we
         *       go into details.
         */
        self::assertEquals(count($expectedParsed), count($actualParsed));

        /**
         * @desc Loop through expected and compare one by one with actual.
         */
        foreach ($expectedParsed as $key => $value) {

            /**
             * @desc Assert that $actualParsed has the key.
             */
            self::assertArrayHasKey($key, $actualParsed, $message);

            switch ($key) {
            default:
                /**
                 * @desc Assert that the values match.
                 */
                self::assertEquals($value, $actualParsed[$key], $message);
                break;
            case 'query':
                parse_str($value, $expectedQuery);
                parse_str($actualParsed[$key], $actualQuery);
                foreach ($expectedQuery as $expectedKey => $expectedValue) {
                    self::assertArrayHasKey($expectedKey, $actualQuery);
                    self::assertEquals($expectedValue, $actualQuery[$expectedKey]);
                }
                break;
            }
        }
    }
}
