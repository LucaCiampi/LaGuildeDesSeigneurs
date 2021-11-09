<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Character;
use App\Service\CharacterServiceInterface;

class CharacterController extends AbstractController
{
    private $characterService;

    public function __construct(CharacterServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }

    // #[Route('/character', name: 'character', methods: ['GET', 'HEAD'])]
    // public function index(): Response
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/CharacterController.php',
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
    public function display(Character $character): Response
    {
        $this->denyAccessUnlessGranted('characterDisplay', $character);

        return new JsonResponse($character->toArray());
    }

    /**
     * Creates new Character
     * @return JsonResponse
     */
    #[Route('/character/create', name: 'character_create', methods: ['POST', 'HEAD'])]
    public function create(Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('characterCreate', null);

        $character = $this->characterService->create($request->getContent());

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
    public function modify(Character $character): JsonResponse
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
    public function delete(Character $character): JsonResponse
    {
        $this->denyAccessUnlessGranted('characterDelete', $character);

        $response = $character = $this->characterService->delete($character);

        return new JsonResponse(array('delete' => $response));
    }

    /**
     * Returns images randomly
     * @Route("/character/images/{number}", 
     * name="character_images",
     * requirements={"number": "^([0-9]{1,2})$"},
     * methods={"GET","HEAD"}
     * )
     */
    public function images(int $number): JsonResponse
    {
        $this->denyAccessUnlessGranted('characterIndex', null);

        $images = $this->characterService->getImages($number);

        return new JsonResponse($images);
    }

    /**
     * Returns images randomly
     * @Route("/character/images/{kind}/{number}", 
     * name="character_images_kind",
     * requirements={"number": "^([0-9]{1,2})$"},
     * methods={"GET","HEAD"}
     * )
     */
    public function getImagesByKind(string $kind, int $number): JsonResponse
    {
        $this->denyAccessUnlessGranted('characterIndex', null);

        $images =  $this->characterService->getImages($number, $kind);

        return new JsonResponse($images);
    }
}
