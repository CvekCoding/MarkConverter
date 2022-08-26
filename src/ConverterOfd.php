<?php

declare(strict_types=1);

namespace Cvek\MarkConverter;

use InvalidArgumentException;

final class ConverterOfd
{
    public function __invoke(string $code): string
    {
        if (1 !== preg_match('/^\x1d?01(\d{14})21(.{13})(\x1d93.{4})?$/', trim($code), $match)) {
            throw new InvalidArgumentException('String has wrong format. Proper format: 01\d{14}21.{13}');
        }

        return (new Mark((int) $match[1], $match[2]))->getHexWithoutSplitting();
    }
}
