<?php

/*
 * This file is part of the hedeqiang/geocode.
 *
 * (c) hedeqiang<laravel_code@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hedeqiang\Geocode\Tests;

use Hedeqiang\Geocode\Exceptions\InvalidArgumentException;
use Hedeqiang\Geocode\GeoCode;
use PHPUnit\Framework\TestCase;

class GeocodeTest extends TestCase
{
    public function testGetGeocodeWithInvalidFormat()
    {
        $g = new GeoCode('mock-key');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid response format: array');

        $g->getGeo('北京市朝阳区阜通东大街6号', '北京', false, 'array');

        $this->fail('Faild to assert getGeo throw exception with invalid argument.');
    }
}
