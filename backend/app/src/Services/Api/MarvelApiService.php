<?php

namespace App\Services\Api;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MarvelApiService
{
    private $client;
    private $param;
    private $baseUrl;
    private $publicKey;
    private $privateKey;

    public function __construct(HttpClientInterface $client, ParameterBagInterface $param)
    {

        $this->client       = $client;
        $this->param        = $param ; 
        $this->baseUrl      = $this->param->get('marvel_api_base_url') ;
        $this->publicKey    = $this->param->get('marvel_api_public_key') ;
        $this->privateKey   = $this->param->get('marvel_api_private_key') ;

    }

    public function getAuthParams(): array
    {
        $timestamp  = time();
        $hash       = md5($timestamp . $this->privateKey . $this->publicKey);

        return [
            'ts'        => $timestamp,
            'apikey'    => $this->publicKey,
            'hash'      => $hash
        ];
    }

    public function getListCharacters(string $endpoint,int $limit , int $offset)
    {

        // Fusion auth paramas with pagination
        $queryParams    = array_merge($this->getAuthParams(), [
            'limit'     => $limit,
            'offset'    => $offset
        ]);

        $response = $this->client->request(
            'GET',
            $this->baseUrl . $endpoint,
            [
                'query' => $queryParams
            ]
        );

        $datas =  $response->toArray();

        // Fetch name and thumbnails only
        $characters = [];
        foreach ($datas['data']['results'] as $character) {

            $characters[]   = [
                'name'      => $character['name'],
                'thumbnail' => $character['thumbnail']['path'] . '.' . $character['thumbnail']['extension']
            ];

        }

        return $characters;

    }
}