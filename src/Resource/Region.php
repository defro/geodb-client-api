<?php

namespace fGalvao\GeoDB\Resource;

use fGalvao\BaseClientApi\Resource;

/**
 * Class Country
 *
 * @property string $code
 * @property string $name
 * @property string $countryCode
 *
 * @package fGalvao\GeoDB\Api\Resource
 */
class Region extends Resource
{
    protected $rootKey = 'data';

    protected $map = [
        'isoCode' => 'code',
        //        'code' => 'code',
        //        'name' => 'name',
    ];

    protected $ignore = [
        'wikiDataId', 'fipsCode',
    ];
}