<?php
/*
 * This file is part of the Aqua Delivery package.
 *
 * (c) Sergey Logachev <svlogachev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cvek\MarkConverter;

use InvalidArgumentException;

final class Converter
{
    public function __invoke(string $code): string
    {
        if (1 !== preg_match('/^01(\d{14})21(.{13})(93.{4})?$/', trim($code), $match)) {
            throw new InvalidArgumentException('String has wrong format. Proper format: 01\d{14}21.{13}');
        }

        return (new Mark((int) $match[1], $match[2]))->getHex();
    }
}
