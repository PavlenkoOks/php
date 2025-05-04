<?php

namespace App\Controller;

use App\Entity\EventOrganizer;
use App\Form\EventOrganizerForm;
use App\Repository\EventOrganizerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/event/organizer')]
final class EventOrganizerController extends AbstractController
{
    #[Route(name: 'app_event_organizer_index', methods: ['GET'])]
    public function index(
        Request $request,
        EventOrganizerRepository $eventOrganizerRepository,
        PaginatorInterface $paginator
    ): Response
    {
        $queryBuilder = $eventOrganizerRepository->createQueryBuilder('o');

        if ($name = $request->query->get('name')) {
            $queryBuilder->andWhere('o.name LIKE :name')->setParameter('name', "%$name%");
        }
        if ($email = $request->query->get('email')) {
            $queryBuilder->andWhere('o.email LIKE :email')->setParameter('email', "%$email%");
        }
        if ($phone = $request->query->get('phone')) {
            $queryBuilder->andWhere('o.phone LIKE :phone')->setParameter('phone', "%$phone%");
        }
        if ($event = $request->query->get('event')) {
            $queryBuilder->andWhere('o.event = :event')->setParameter('event', $event);
        }

        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);

        $pagination = $paginator->paginate(
            $queryBuilder,
            $page,
            $limit
        );

        return $this->render('event_organizer/index.html.twig', [
            'pagination' => $pagination,
            'filters' => [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'event' => $event,
                'limit' => $limit,
            ],
        ]);
    }
    #[Route('/new', name: 'app_event_organizer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eventOrganizer = new EventOrganizer();
        $form = $this->createForm(EventOrganizerForm::class, $eventOrganizer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eventOrganizer);
            $entityManager->flush();

            return $this->redirectToRoute('app_event_organizer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event_organizer/new.html.twig', [
            'event_organizer' => $eventOrganizer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_organizer_show', methods: ['GET'])]
    public function show(EventOrganizer $eventOrganizer): Response
    {
        return $this->render('event_organizer/show.html.twig', [
            'event_organizer' => $eventOrganizer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_event_organizer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EventOrganizer $eventOrganizer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventOrganizerForm::class, $eventOrganizer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_event_organizer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event_organizer/edit.html.twig', [
            'event_organizer' => $eventOrganizer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_organizer_delete', methods: ['POST'])]
    public function delete(Request $request, EventOrganizer $eventOrganizer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventOrganizer->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($eventOrganizer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_event_organizer_index', [], Response::HTTP_SEE_OTHER);
    }
}
