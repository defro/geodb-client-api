<?php

namespace fGalvao\GeoDB;

use fGalvao\BaseClientApi\HttpClient;
use fGalvao\BaseClientApi\Response;
use fGalvao\GeoDB\Api\Geo;
use InvalidArgumentException;

class GeoDB
{
    /**
     * @var Geo
     */
    private $geo;

    public function __construct(HttpClient $httpClient)
    {
        $this->geo = new Geo($httpClient);
    }

    /**
     * Build the client setting
     * ##Settings
     * * BASE_URL (required)
     * * API_HOST (required)
     * * API_KEY (required)
     * * DEV_MODE
     *
     * @param array $settings
     *
     * @return array
     */
    public static function buildClientSettings(array $settings): array
    {
        $missing = array_diff(['BASE_URL', 'API_HOST', 'API_KEY'], array_keys($settings));
        if (count($missing)) {
            throw new InvalidArgumentException(sprintf('Missing required setting: %s', implode(',', $missing)));
        }

        return [
            'verify'      => !$settings['DEV_MODE'] ?? true,
            'http_errors' => false,
            // Base URI is used with relative requests
            'base_uri'    => ltrim($settings['BASE_URL'], '/'),
            'headers'     => [
                'Content-Type'    => 'application/json',
                'Accept'          => 'application/json',
                'x-rapidapi-host' => $settings['API_HOST'],
                'x-rapidapi-key'  => $settings['API_KEY'],
            ],
        ];
    }


    /**
     * Find countries, filtering by optional criteria.
     * If no criteria are set, you will get back all known countries<br>
     * see {@see Geo::countries} for full understanding
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
     */
    public function countries(string $prefix = null, string $langCode = null, array $params = [])
    {
        return $this->geo->countries($prefix, $langCode, $params);
    }


    /**
     * Get all regions in a specific country.
     * These could be states, provinces, districts, or otherwise major political divisions.<br>
     * see {@see Geo::regions} for full understanding
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
     */
    public function regions(string $countryCode, string $prefix = null, string $langCode = null, array $params = [])
    {
        return $this->geo->regions($countryCode, $prefix, $langCode, $params);
    }

    /**
     * Get the cities in a specific country region.
     * The country and region info is omitted in the response.
     *
     * @link https://wirefreethought.github.io/geodb-cities-api-docs/#operation--v1-geo-countries--countryId--regions--regionCode--cities-get
     *
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
     */
    public function cities(string $countryCode, string $regionCode, string $prefix = null, string $langCode = null, array $params = [])
    {
        return $this->geo->cities($countryCode, $regionCode, $prefix, $langCode, $params);
    }

}