<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventForm;
use App\Repository\EventRepository;
use App\Utils\JwtHelper;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/event')]
final class EventController extends AbstractController
{
    #[Route(name: 'app_event_index', methods: ['GET'])]
    public function index(
        Request $request,
        EventRepository $eventRepository,
        PaginatorInterface $paginator
    ): Response
    {
        $queryBuilder = $eventRepository->createQueryBuilder('e');

        if ($title = $request->query->get('title')) {
            $queryBuilder->andWhere('e.title LIKE :title')->setParameter('title', "%$title%");
        }
        if ($description = $request->query->get('description')) {
            $queryBuilder->andWhere('e.description LIKE :description')->setParameter('description', "%$description%");
        }
        if ($eventDate = $request->query->get('eventDate')) {
            $queryBuilder->andWhere('DATE(e.eventDate) = :eventDate')->setParameter('eventDate', $eventDate);
        }
        if ($location = $request->query->get('location')) {
            $queryBuilder->andWhere('e.location = :location')->setParameter('location', $location);
        }
        if ($ticketPrice = $request->query->get('ticketPrice')) {
            $queryBuilder->andWhere('e.ticketPrice = :ticketPrice')->setParameter('ticketPrice', $ticketPrice);
        }

        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);

        $pagination = $paginator->paginate(
            $queryBuilder,
            $page,
            $limit
        );

        return $this->render('event/index.html.twig', [
            'pagination' => $pagination,
            'filters' => [
                'title' => $title,
                'description' => $description,
                'eventDate' => $eventDate,
                'location' => $location,
                'ticketPrice' => $ticketPrice,
                'limit' => $limit,
            ],
        ]);
    }
    #[Route('/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $role = JwtHelper::getUserRole($request);
        if (!in_array($role, ['Admin', 'Manager'])) {
            return $this->redirectToRoute('app_event_index');
        }

        $event = new Event();
        $form = $this->createForm(EventForm::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_event_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $role = JwtHelper::getUserRole($request);
        if (!in_array($role, ['Admin', 'Manager'])) {
            return $this->redirectToRoute('app_event_index');
        }


        $form = $this->createForm(EventForm::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $role = JwtHelper::getUserRole($request);
        if (!in_array($role, ['Admin', 'Manager'])) {
            return $this->redirectToRoute('app_event_index');
        }


        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
    }
}
