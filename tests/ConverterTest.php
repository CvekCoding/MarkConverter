<?php
/*
 * This file is part of the Aqua Delivery package.
 *
 * (c) Sergey Logachev <svlogachev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cvek\MarkConverter\Tests;

use Cvek\MarkConverter\Converter;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    public function testSimpleStringGoodMark(): void
    {
        $code = '010463003407001221SxMGorvNuq6Wk';

        $hex = (new Converter())($code);

        self::assertSame('44 4D 04 36 03 89 39 FC 53 78 4D 47 6F 72 76 4E 75 71 36 57 6B', $hex);
    }

    public function testTrim(): void
    {
        $code = ' 010463003407001221SxMGorvNuq6Wk';

        $hex = (new Converter())($code);

        self::assertSame('44 4D 04 36 03 89 39 FC 53 78 4D 47 6F 72 76 4E 75 71 36 57 6B', $hex);
    }

    /** Code may come with control character 93 */
    public function testWithControlChars(): void
    {
        $code = mb_chr(0x1d, 'UTF-8').'010463003407001221SxMGorvNuq6Wk'.mb_chr(0x1d, 'UTF-8').'936W7E';

        $hex = (new Converter())($code);

        self::assertSame('44 4D 04 36 03 89 39 FC 53 78 4D 47 6F 72 76 4E 75 71 36 57 6B', $hex);
    }

    public function testShortMark(): void
    {
        $code = '010463003407001221SxMGorvNuq6W';

        $this->expectException(\InvalidArgumentException::class);

        (new Converter())($code);
    }

    public function testTooLongMark(): void
    {
        $code = '010463003407001221SxMGorvNuq6Wkk';

        $this->expectException(\InvalidArgumentException::class);

        (new Converter())($code);
    }
}
