<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventFormType;
use App\Repository\EventRepository;
use App\Search\DatabaseEventSearch;
use App\Search\EventSearchInterface;
use App\Security\Voter\EditionVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/event', name: 'event_route')]
class EventController extends AbstractController
{

    #[Route('/', name: 'app_event_index', methods: ['GET'])]
    public function index(Request $request, DatabaseEventSearch $eventSearch): Response
    {
        $events = $eventSearch->searchByName($request->query->get('name', null));

        return $this->render('event/list_events.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/search', name: 'app_event_search', methods: ['GET'])]
    #[Template('event/search_events.html.twig')]
    public function searchEvents(Request $request, EventSearchInterface $search): array
    {
        $events = $search->searchByName($request->query->get('name', null))['hydra:member'];
        return ['events' => $events];
    }

    #[Route('/id/{id}', name: 'app_event_query_by_id', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function listEventByID(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @throws \DateMalformedStringException
     */
    /*
    #[Route('/{name}/{start}/{end}', name: 'app_event_new_with_start_and_end')]
    public function newEventWithStartAndEnd
    (
        string                 $name,
        string                 $start,
        string                 $end,
        EntityManagerInterface $entityManger
    ): Response
    {
        $event = (new Event())
            ->setName($name)
            ->setDescription('Some generic description')
            ->setIsAccessible(true)
            ->setStartAt(new \DateTimeImmutable($start))
            ->setEndAt(new \DateTimeImmutable($end));

        $entityManger->persist($event);

        $entityManger->flush();

        return new Response('Event created!', Response::HTTP_CREATED);
    }*/

    /**
     * @throws \DateMalformedStringException
     */
    #[Route('/{start}/{end}', name: 'app_event_query_by_date')]
    public function queryEventsByDate(string $start, string $end, EventRepository $eventRepository): Response
    {
        $event = $eventRepository->getEventsByDate(new \DateTimeImmutable($start), new \DateTimeImmutable($end));
        return new JsonResponse($event);
    }

    #[Route('/id/{id}/edit', name: 'app_event_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function newEvent(Request $request, EntityManagerInterface $entityManager, Event $event = new Event()): Response
    {
        if ($event instanceof Event)
        {
            $this->denyAccessUnlessGranted(EditionVoter::EVENT, $event);
        }

        $form = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$event->getId())
            {
                $event->setCreatedBy($this->getUser());
            }

            $entityManager->persist($event);
            $entityManager->flush();
            return $this->redirectToRoute('event_routeapp_event_query_by_id', ['id' => $event->getId()]);
        }
        return $this->render('event/new_event.html.twig', [
            'form' => $form,
        ]);
    }
}
