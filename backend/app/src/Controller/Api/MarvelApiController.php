<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Services\Api\MarvelApiService as ApiMarvelApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MarvelApiController extends AbstractController
{
    private $marvelApi;

    public function __construct(ApiMarvelApiService $marvelApi)
    {
        $this->marvelApi = $marvelApi;
    }

    #[Route('/api/marvel/characters', name: 'marvel_characters_list', methods: ['GET'])]
    public function getCharacters(): Response
    {

        // Récupérer les paramètres de limite et offset depuis la requête
        $limit      = $_GET['limit'] ?? 20;
        $offset     = $_GET['offset'] ?? 0;

        $characters = $this->marvelApi->getListCharacters('/characters' , $limit , $offset);

        if ($characters) {
            # code...
            
            return new JsonResponse([
    
                "data"      => $characters,
                "code"      => Response::HTTP_OK,
                "success"   => true,
                "message"   => "Listing datas with success"
    
            ]);
        }
        else {
            # code...
            return new JsonResponse([
                "data"      => [], 
                "code"      => Response::HTTP_BAD_REQUEST , 
                "success"   => false ,
                "message"   => "No request found" ,
        
            ]);
        }
        
    }
}