<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Services\Api\MarvelApiService;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MarvelApiServiceTest extends TestCase
{
    public function testGetCharactersSuccess()
    {
        // Création des mocks pour le client HTTP et les paramètres
        $httpClient   = $this->createMock(HttpClientInterface::class);
        $response     = $this->createMock(ResponseInterface::class);
        $parameterBag = $this->createMock(ParameterBagInterface::class);

        // Simuler les valeurs retournées par le ParameterBag
        $parameterBag
            ->method('get')
            ->willReturnMap([
                ['marvel_api_base_url', 'https://gateway.marvel.com/v1/public/'],
                ['marvel_api_public_key', 'public_key_test'],
                ['marvel_api_private_key', 'private_key_test'],
            ]);

        // Simuler la réponse du client HTTP
        $httpClient
            ->expects($this->once())
            ->method('request')
            ->with(
                'GET',
                'https://gateway.marvel.com/v1/public/characters',
                $this->callback(function ($options) {
                    return isset($options['query']['limit']) &&
                           isset($options['query']['offset']) &&
                           isset($options['query']['ts']) &&
                           isset($options['query']['apikey']) &&
                           isset($options['query']['hash']);
                })
            )
            ->willReturn($response);

        // Simuler le contenu JSON retourné par l'API
        $response
            ->method('toArray')
            ->willReturn([
                'data' => [
                    'results' => [
                        ['name' => 'Iron Man', 'thumbnail' => ['path' => 'ironman', 'extension' => 'jpg']],
                        ['name' => 'Captain America', 'thumbnail' => ['path' => 'captainamerica', 'extension' => 'jpg']],
                    ],
                ],
            ]);

        // Instancier le service avec les mocks
        $marvelApiService = new MarvelApiService($httpClient, $parameterBag);

        // Appeler la méthode avec les bons paramètres
        $characters = $marvelApiService->getListCharacters('characters', 20, 0);

        // Assertions
        $this->assertIsArray($characters);
        $this->assertCount(2, $characters);
        $this->assertEquals('Iron Man', $characters[0]['name']);
        $this->assertEquals('ironman.jpg', $characters[0]['thumbnail']);
    }

    public function testGetCharactersFailure()
    {
        // Création des mocks pour le client HTTP et les paramètres
        $httpClient   = $this->createMock(HttpClientInterface::class);
        $response     = $this->createMock(ResponseInterface::class);
        $parameterBag = $this->createMock(ParameterBagInterface::class);

        // Simuler les valeurs retournées par le ParameterBag
        $parameterBag
            ->method('get')
            ->willReturnMap([
                ['marvel_api_base_url', 'https://gateway.marvel.com/v1/public/'],
                ['marvel_api_public_key', 'public_key_test'],
                ['marvel_api_private_key', 'private_key_test'],
            ]);

        // Simuler une réponse d'erreur
        $httpClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        // Simuler un contenu d'erreur
        $response
            ->method('toArray')
            ->willReturn([
                'code' => 500,
                'success' => false,
                'message' => 'Error fetching data',
            ]);

        // Instancier le service avec les mocks
        $marvelApiService = new MarvelApiService($httpClient, $parameterBag);

        // Appeler la méthode avec les bons paramètres
        $characters = $marvelApiService->getListCharacters('characters', 20, 0);

        // Assertions
        $this->assertIsArray($characters);
        $this->assertCount(0, $characters);
    }
}
