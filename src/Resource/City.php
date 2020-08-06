<?php

namespace fGalvao\GeoDB\Resource;

use fGalvao\BaseClientApi\Resource;

/**
 * Class Country
 *
 * @property string $id
 * @property string $type
 * @property string $name
 * @property string $city
 * @property float  $latitude
 * @property float  $longitude
 *
 * @package fGalvao\GeoDB\Api\Resource
 */
class City extends Resource
{
    protected $rootKey = 'data';

    protected $map = [];

    protected $ignore = [
        'wikiDataId',
    ];
}