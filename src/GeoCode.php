<?php

namespace Hedeqiang\Geocode;
use GuzzleHttp\Client;
use Hedeqiang\Geocode\Exceptions\HttpException;
use Hedeqiang\Geocode\Exceptions\InvalidArgumentException;

class GeoCode
{
    protected $key;
    protected $guzzleOptions = [];

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }


    public function getGeo($address,$city,$batch = false,$format = 'json')
    {
        $url = 'https://restapi.amap.com/v3/geocode/geo';

        if (!\in_array(\strtolower($format), ['xml', 'json'])) {
            throw new InvalidArgumentException('Invalid response format: '.$format);
        }
        $query = array_filter([
            'key' => $this->key,
            'address' => $address,
            'city' => $city,
            'batch' => $batch,
            'output' => $format,
        ]);
        try {
            $response = $this->getHttpClient()->get($url, [
                'query' => $query,
            ])->getBody()->getContents();

            return 'json' === $format ? \json_decode($response, true) : $response;

        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }


    public function getRegeo($location,$poitype,$radius = 1000,$type ='all',$batch = false,$roadlevel= 0,$format = 'json')
    {
        $url = 'https://restapi.amap.com/v3/geocode/regeo';

        if (!\in_array(\strtolower($format), ['xml', 'json'])) {
            throw new InvalidArgumentException('Invalid response format: '.$format);
        }

        if (!is_numeric($radius))
        {
            throw new InvalidArgumentException('Invalid radius value : '.$radius);
        }

        if ($radius < 0 || $radius >3000)
        {
            throw new InvalidArgumentException('Invalid radius value(0~3000): '.$radius);
        }

        if (!\in_array(\strtolower($type), ['base', 'all'])) {
            throw new InvalidArgumentException('Invalid type value(base/all): '.$type);
        }



        $query = array_filter([
            'key' => $this->key,
            'location' => $location,
            'poitype' => $poitype,
            'radius' => $radius,
            'extensions' => $type,
            'batch' => $batch,
            'roadlevel' => $roadlevel,
            'output' => $format,
        ]);
        try {
            $response = $this->getHttpClient()->get($url, [
                'query' => $query,
            ])->getBody()->getContents();

            return 'json' === $format ? \json_decode($response, true) : $response;

        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}