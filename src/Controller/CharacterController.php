<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Character;
use App\Service\CharacterServiceInterface;

class CharacterController extends AbstractController
{
    private $characterService;

    public function __construct(CharacterServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }

    #[Route('/character', name: 'character', methods: ['GET', 'HEAD'])]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CharacterController.php',
        ]);
    }

    /**
     * // Fonctionne également dans le format dessus ^
     * @Route("/character/display", 
     * name="character_display",
     * methods={"GET","HEAD"})
     */
    public function display(): Response
    {
        $character = new Character();

        return new JsonResponse($character->toArray());
    }

    /**
     * Creates new Character
     * @return JsonResponse
     */
    #[Route('/character/create', name: 'character_create', methods: ['POST', 'HEAD'])]
    public function create(): JsonResponse
    {
        $character = $this->characterService->create();

        return new JsonResponse($character->toArray());
    }
}
