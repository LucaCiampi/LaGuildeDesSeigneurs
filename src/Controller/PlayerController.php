<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Service\PlayerServiceInterface;
use App\Entity\Player;

class PlayerController extends AbstractController
{
    private $playerService;

    public function __construct(PlayerServiceInterface $playerService)
    {
        $this->playerService = $playerService;

    }

    // #[Route('/player', name: 'player', methods: ['GET', 'HEAD'])]
    // public function index(): Response
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/PlayerController.php',
    //     ]);
    // }

    /**
     * // Fonctionne également dans le format dessus ^
     * @Route("/player/display/{identifier}", 
     * name="player_display",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"GET","HEAD"}
     * )
     * @Entity("player", expr="repository.findOneByIdentifier(identifier)")
     */
    public function display(Player $player): Response
    {
        $this->denyAccessUnlessGranted('playerDisplay', $player);

        return JsonResponse::fromJsonString($this->playerService->serializeJson($player));
    }

    /**
     * Creates new Player
     * @return JsonResponse
     */
    #[Route('/player/create', name: 'player_create', methods: ['POST', 'HEAD'])]
    public function create(Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('playerCreate', null);

        $player = $this->playerService->create($request->getContent());

        return JsonResponse::fromJsonString($this->playerService->serializeJson($player));
    }

    /**
     * @Route("/player/modify/{identifier}", 
     * name="player_modify",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"PUT","HEAD"}
     * )
     */
    public function modify(Player $player, Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('playerModify', $player);

        $player = $this->playerService->modify($player, $request->getContent());

        return JsonResponse::fromJsonString($this->playerService->serializeJson($player));
    }

    /**
     * @Route("/player", 
     * name="player_redirect_index",
     * methods={"GET","HEAD"}
     * )
     */
    public function redirectIndex()
    {
        return $this->redirectToRoute('player_index');
    }

    /**
     * @Route("/player/index", 
     * name="player_index",
     * methods={"GET","HEAD"}
     * )
     */
    public function index(): JsonResponse
    {
        $this->denyAccessUnlessGranted('playerIndex', null);

        $players = $this->playerService->getAll();

        return new JsonResponse($players);
    }

    /**
     * @Route("/player/delete/{identifier}", 
     * name="player_delete",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"DELETE","HEAD"}
     * )
     */
    public function delete(Player $player): JsonResponse
    {
        $this->denyAccessUnlessGranted('playerDelete', $player);

        $response = $player = $this->playerService->delete($player);

        return new JsonResponse(array('delete' => $response));
    }
}
