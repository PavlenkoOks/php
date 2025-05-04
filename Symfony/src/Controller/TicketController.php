<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketForm;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ticket')]
final class TicketController extends AbstractController
{
    #[Route(name: 'app_ticket_index', methods: ['GET'])]
    public function index(
        Request $request,
        TicketRepository $ticketRepository,
        PaginatorInterface $paginator
    ): Response
    {
        $queryBuilder = $ticketRepository->createQueryBuilder('t');

        if ($event = $request->query->get('event')) {
            $queryBuilder->andWhere('t.event = :event')->setParameter('event', $event);
        }
        if ($participant = $request->query->get('participant')) {
            $queryBuilder->andWhere('t.participant = :participant')->setParameter('participant', $participant);
        }
        if ($purchaseDate = $request->query->get('purchaseDate')) {
            $queryBuilder->andWhere('DATE(t.purchaseDate) = :purchaseDate')->setParameter('purchaseDate', $purchaseDate);
        }
        if ($pricePaid = $request->query->get('pricePaid')) {
            $queryBuilder->andWhere('t.pricePaid = :pricePaid')->setParameter('pricePaid', $pricePaid);
        }

        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);

        $pagination = $paginator->paginate(
            $queryBuilder,
            $page,
            $limit
        );

        return $this->render('ticket/index.html.twig', [
            'pagination' => $pagination,
            'filters' => [
                'event' => $event,
                'participant' => $participant,
                'purchaseDate' => $purchaseDate,
                'pricePaid' => $pricePaid,
                'limit' => $limit,
            ],
        ]);
    }
    #[Route('/new', name: 'app_ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketForm::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ticket/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(Ticket $ticket): Response
    {
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ticket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TicketForm::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_delete', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ticket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
    }
}
