<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Character;

class CharacterController extends AbstractController
{
    #[Route('/character', name: 'character')]
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
}
