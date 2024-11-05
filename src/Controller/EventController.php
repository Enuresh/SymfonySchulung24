<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventFormType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/event', name: 'event_route')]
class EventController extends AbstractController
{

    #[Route('/', name: 'app_event_index', methods: ['GET'])]
    public function index(EventRepository $repository): Response
    {
        $events = $repository->findAll();

        return $this->render('event/list_events.html.twig', [
            'events' => $events,
        ]);
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
            ->setAccessible(true)
            ->setStartAt(new \DateTimeImmutable($start))
            ->setEndAt(new \DateTimeImmutable($end));

        $entityManger->persist($event);

        $entityManger->flush();

        return new Response('Event created!', Response::HTTP_CREATED);
    }

    /**
     * @throws \DateMalformedStringException
     */
    #[Route('/{start}/{end}', name: 'app_event_query_by_date')]
    public function queryEventsByDate(string $start, string $end, EventRepository $eventRepository): Response
    {
        $event = $eventRepository->getEventsByDate(new \DateTimeImmutable($start), new \DateTimeImmutable($end));
        return new JsonResponse($event);
    }

    #[Route('/event/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function newEvent(Request $request, EntityManagerInterface $manager): Response
    {
        $event = new Event();
        $form = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($event);
            $manager->flush();
            return $this->redirectToRoute('event_routeapp_event_query_by_id', ['id' => $event->getId()]);
        }
        return $this->render('event/new_event.html.twig', [
            'form' => $form,
        ]);
    }
}
