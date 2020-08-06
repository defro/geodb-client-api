<?php

namespace fGalvao\GeoDB\Api;

use fGalvao\BaseClientApi\Requester;
use fGalvao\BaseClientApi\Response;
use fGalvao\GeoDB\Resource\City as CityResource;
use fGalvao\GeoDB\Resource\Country as CountryResource;
use fGalvao\GeoDB\Resource\Region as RegionResource;

/**
 * Class Geo
 *
 * @package fGalvao\GeoDB\Api
 * @link    https://wirefreethought.github.io/geodb-cities-api-docs
 */
class Geo extends Requester
{

    /**
     * Find countries, filtering by optional criteria.
     * If no criteria are set, you will get back all known countries
     *
     * @param string|null $prefix   Only countries whose names start with this prefix. If languageCode is set, the
     *                              prefix will be matched on the name as it appears in that language.
     * @param string|null $langCode Display results in this language
     * @param array       $params   array <br>
     *                              currencyCode: string  -> Only countries supporting this currency <br>
     *                              asciiMode: boolean (default: false) -> Display results using ASCII characters <br>
     *                              hateoasMode: boolean (default: true) -> Include HATEOAS-style links in results
     *                              <br>
     *                              offset: integer (int32) (default: 0) -> The maximum number of results to retrieve
     *                              <br> limit: integer (int32) (default: 10) -> The zero-ary offset index into the
     *                              results
     *
     * @return Response
     *
     * @link https://wirefreethought.github.io/geodb-cities-api-docs/#operation--v1-geo-countries-get
     */
    public function countries(string $prefix = null, string $langCode = null, array $params = [])
    {
        $uri = '/v1/geo/countries';

        if ($prefix) {
            $params['namePrefix'] = $prefix;
        }

        if ($langCode) {
            $params['languageCode'] = $langCode;
        }

        $_response = $this->get($uri, $params);
        $response  = $this->toResourceResponse($_response, CountryResource::class);

        return $response;
    }

    /**
     * Get all regions in a specific country.
     * These could be states, provinces, districts, or otherwise major political divisions.
     *
     * @param string      $countryCode An ISO-3166 country code or WikiData id
     * @param string|null $prefix      Only regions whose names start with this prefix.
     *                                 If languageCode is set, the prefix will be matched on the name as it appears in
     *                                 that language.
     * @param string|null $langCode    Display results in this language
     * @param array       $params      array <br>
     *                                 - asciiMode: boolean (default: false) -> Display results using ASCII
     *                                 characters<br>
     *                                 - hateoasMode: boolean (default: true) -> Include HATEOAS-style links in
     *                                 results <br>
     *                                 - offset: integer (int32) (default: 0) -> The maximum number of results to
     *                                 retrieve<br>
     *                                 - limit: integer (int32) (default: 10) -> The zero-ary offset index into the
     *                                 results
     *
     * @return Response
     *
     * @link https://wirefreethought.github.io/geodb-cities-api-docs/#operation--v1-geo-countries--countryId--regions-get
     */
    public function regions(string $countryCode, string $prefix = null, string $langCode = null, array $params = [])
    {
        $uri = '/v1/geo/countries/%s/regions';
        $uri = sprintf($uri, $countryCode);


        if ($prefix) {
            $params['namePrefix'] = $prefix;
        }

        if ($langCode) {
            $params['languageCode'] = $langCode;
        }

        $_response = $this->get($uri, $params);
        $response  = $this->toResourceResponse($_response, RegionResource::class);

        return $response;
    }


    /**
     * Get the cities in a specific country region.
     * The country and region info is omitted in the response.
     *
     * @param string      $countryCode An ISO-3166 country code or WikiData id
     * @param string      $regionCode  An ISO-3166 or FIPS region code
     * @param string|null $prefix      Only cities whose names start with this prefix. If languageCode is set, the
     *                                 prefix will be matched on the name as it appears in that language.
     * @param string|null $langCode    Display results in this language
     * @param array       $params      array <br>
     *                                 - minPopulation: integer (default: 0) -> Only cities having at least this
     *                                 population <br>
     *                                 - timeZoneIds: string -> Only cities in these time-zones (comma-delimited) <br>
     *                                 - types: string (default: CITY) -> Only cities for these types
     *                                 (comma-delimited): CITY | ADM2 <br>
     *                                 - asciiMode: boolean (default: false) -> Display results using ASCII
     *                                 characters<br>
     *                                 - hateoasMode: boolean (default: true) -> Include HATEOAS-style links in
     *                                 results <br>
     *                                 - offset: integer (int32) (default: 0) -> The maximum number of results to
     *                                 retrieve<br>
     *                                 - limit: integer (int32) (default: 10) -> The zero-ary offset index into the
     *                                 results<br>
     *                                 - sort: string (default: population,name) -> How to sort the results.
     *                                 Format: ±SORT_FIELD, ±SORT_FIELD where SORT_FIELD = elevation | name |
     *                                 population
     *                                 <br>
     *                                 - includeDeleted: string (default: NONE) -> Whether to include any cities marked
     *                                 deleted: ALL | SINCE_YESTERDAY | SINCE_LAST_WEEK | NONE
     *
     * @return Response
     *
     * @link https://wirefreethought.github.io/geodb-cities-api-docs/#operation--v1-geo-countries--countryId--regions--regionCode--cities-get
     */
    public function cities(string $countryCode, string $regionCode, string $prefix = null, string $langCode = null, array $params = [])
    {
        $uri = '/v1/geo/countries/%s/regions/%s/cities';
        $uri = sprintf($uri, $countryCode, $regionCode);


        if ($prefix) {
            $params['namePrefix'] = $prefix;
        }

        if ($langCode) {
            $params['languageCode'] = $langCode;
        }

        if (!key_exists('types', $params)) {
            $params['types'] = 'CITY';

        }

        if (!key_exists('sort', $params)) {
            $params['sort'] = 'population,name';
        }

        $_response = $this->get($uri, $params);
        $response  = $this->toResourceResponse($_response, CityResource::class);

        return $response;
    }

}