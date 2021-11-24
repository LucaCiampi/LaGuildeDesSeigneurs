<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Character;
use App\Service\CharacterServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class CharacterController extends AbstractController
{
    private $characterService;

    public function __construct(CharacterServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }

    /**
     * @Route("/character",
     * name="character_redirect_index",
     * methods={"GET","HEAD"}
     * )
     * @OA\Response(
     *      response=200,
     *      description="Success"
     * )
     * OA\Tag(name="Character")
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
     * @OA\Response(
     *      response=200,
     *      description="Success"
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied"
     * )
     * OA\Tag(name="Character")
     */
    public function index(): JsonResponse
    {
        $this->denyAccessUnlessGranted('characterIndex', null);

        $characters = $this->characterService->getAll();

        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }

    /**
     * @Route("/character/display/{identifier}",
     * name="character_display",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"GET","HEAD"}
     * )
     * @Entity("character", expr="repository.findOneByIdentifier(identifier)")
     * @OA\Parameter(
     *      name="identifier",
     *      in="path",
     *      description="identifier for the Character",
     *      required=true
     * )
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class)
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied"
     * )
     * @OA\Response(
     *      response=404,
     *      description="Not found"
     * )
     * OA\Tag(name="Character")
     */
    public function display(Character $character): Response
    {
        $this->denyAccessUnlessGranted('characterDisplay', $character);

        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    /**
     * Creates new Character
     * @return JsonResponse
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class)
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied"
     * )
     * @OA\RequestBody(
     *      request="Character",
     *      description="Data for the Character",
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/Character")
     *      )
     * )
     * OA\Tag(name="Character")
     */
    #[Route('/character/create', name: 'character_create', methods: ['POST', 'HEAD'])]
    public function create(Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('characterCreate', null);

        $character = $this->characterService->create($request->getContent());

        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    /**
     * @Route("/character/modify/{identifier}",
     * name="character_modify",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"PUT","HEAD"}
     * )
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class)
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied"
     * )
     * @OA\RequestBody(
     *      request="Character",
     *      description="Data for the Character",
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/Character")
     *      )
     * )
     * OA\Tag(name="Character")
     */
    public function modify(Request $request, Character $character): JsonResponse
    {
        $this->denyAccessUnlessGranted('characterModify', $character);

        $character = $this->characterService->modify($character, $request->getContent());

        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    /**
     * @Route("/character/delete/{identifier}",
     * name="character_delete",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"DELETE","HEAD"}
     * )
     * @OA\Parameter(
     *      name="identifier",
     *      in="path",
     *      description="identifier for the Character",
     *      required=true
     * )
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\Schema(
     *          @OA\Property(property="delete", type="boolean")
     *      )
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied"
     * )
     * @OA\RequestBody(
     *      request="Character",
     *      description="Data for the Character",
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/Character")
     *      )
     * )
     * OA\Tag(name="Character")
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
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class)
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied"
     * )
     * OA\Tag(name="Character")
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
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class)
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied"
     * )
     * OA\Tag(name="Character")
     */
    public function getImagesByKind(string $kind, int $number): JsonResponse
    {
        $this->denyAccessUnlessGranted('characterIndex', null);

        $images =  $this->characterService->getImages($number, $kind);

        return new JsonResponse($images);
    }

    /**
     * Returns characters with intelligence above one passed in parameter
     * @Route("/character/intelligence/{intelligence}",
     * name="character_filter_intelligence",
     * requirements={"intelligence": "^([0-9]{1,3})$"},
     * methods={"GET","HEAD"}
     * )
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class)
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied"
     * )
     * OA\Tag(name="Character")
     */
    public function getCharactersByIntelligence(int $intelligence): JsonResponse
    {
        $this->denyAccessUnlessGranted('characterIndex', null);

        $images =  $this->characterService->getFromIntelligence($intelligence);

        return new JsonResponse($images);
    }
}
