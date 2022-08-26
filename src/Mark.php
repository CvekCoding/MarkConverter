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

use Webmozart\Assert\Assert;

final class Mark
{
    public const DATA_MATRIX_PREFIX = '444D';

    private int $gtin;
    private string $serial;

    public function __construct(int $gtin, string $serial)
    {
        Assert::length($serial, 13);

        $this->gtin = $gtin;
        $this->serial = $serial;
    }

    public function getHex(): string
    {
        $hex = self::DATA_MATRIX_PREFIX
            .$this->getGtinHex()
            .$this->getSerialHex();

        return trim(chunk_split($hex, 2, ' '));
    }

    public function getHexWithoutSplitting(): string
    {
        return trim(self::DATA_MATRIX_PREFIX.$this->getGtinHex().$this->getSerialHex());
    }

    private function getGtinHex(): string
    {
        return sprintf('%012X', $this->gtin);
    }

    private function getSerialHex(): string
    {
        return strtoupper(bin2hex($this->serial));
    }
}
