<?php

namespace App\Controller\Api;

use App\Parser\ApiResultParser;
use App\Repository\VolunteerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class VolunteerApiController extends AbstractController
{
    #[Route('/api/volunteers', name: 'app_volunteer_api')]
    public function index(VolunteerRepository $volunteerRepository, SerializerInterface $serializer): JsonResponse
    {
        $volunteers = $volunteerRepository->findAll();
        $context = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function(object $object, string $format, array $context) {
                return $object->getId();
            }
        ];

        $data =  $serializer->serialize($volunteers, 'json', $context);

        return new JsonResponse($data, Response::HTTP_OK, json: true);
        /*
        $result = $volunteerRepository->findAll();
        return new JsonResponse($serializer->serialize($result, 'json'), json: true);*/
        //return $this->json(array_map(fn($item) => $item->toArray(), $result));
    }
}
