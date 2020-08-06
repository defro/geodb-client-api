<?php

namespace fGalvao\GeoDB\Resource;

use fGalvao\BaseClientApi\Resource;

/**
 * Class Country
 *
 * @property string $code
 * @property string $name
 * @property array  $currencies
 * @property string $wikiDataId
 *
 * @package fGalvao\GeoDB\Api\Resource
 */
class Country extends Resource
{
    protected $rootKey = 'data';

    protected $map = [
        'currencyCodes' => 'currencies',
        //        'code' => 'code',
        //        'name' => 'name',
    ];

    protected $ignore = [
        'wikiDataId',
    ];
}