<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Player;
use App\Service\PlayerServiceInterface;

class PlayerController extends AbstractController
{
    private $characterService;

    public function __construct(PlayerServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }

    // #[Route('/character', name: 'character', methods: ['GET', 'HEAD'])]
    // public function index(): Response
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/PlayerController.php',
    //     ]);
    // }

    /**
     * // Fonctionne également dans le format dessus ^
     * @Route("/character/display/{identifier}", 
     * name="character_display",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"GET","HEAD"}
     * )
     */
    public function display(Player $character): Response
    {
        $this->denyAccessUnlessGranted('characterDisplay', $character);

        return new JsonResponse($character->toArray());
    }

    /**
     * Creates new Player
     * @return JsonResponse
     */
    #[Route('/character/create', name: 'character_create', methods: ['POST', 'HEAD'])]
    public function create(): JsonResponse
    {
        $this->denyAccessUnlessGranted('characterCreate', null);

        $character = $this->characterService->create();

        return new JsonResponse($character->toArray());
    }

    /**
     * @Route("/character", 
     * name="character_redirect_index",
     * methods={"GET","HEAD"}
     * )
     */
    public function redirectIndex()
    {
        return $this->redirectToRoute('character_index');
    }

    /**
     * @Route("/character/index", 
     * name="character_index",
     * methods={"GET","HEAD"}
     * )
     */
    public function index(): JsonResponse
    {
        $this->denyAccessUnlessGranted('characterIndex', null);

        $characters = $this->characterService->getAll();

        return new JsonResponse($characters);
    }

    /**
     * @Route("/character/modify/{identifier}", 
     * name="character_modify",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"PUT","HEAD"}
     * )
     */
    public function modify(Player $character): JsonResponse
    {
        $this->denyAccessUnlessGranted('characterModify', $character);

        $character = $this->characterService->modify($character);

        return new JsonResponse($character);
    }

    /**
     * @Route("/character/delete/{identifier}", 
     * name="character_delete",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"DELETE","HEAD"}
     * )
     */
    public function delete(Player $character): JsonResponse
    {
        $this->denyAccessUnlessGranted('characterDelete', $character);

        $response = $character = $this->characterService->delete($character);

        return new JsonResponse(array('delete' => $response));
    }
}
