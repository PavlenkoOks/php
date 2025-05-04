<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantForm;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/participant')]
final class ParticipantController extends AbstractController
{
    #[Route(name: 'app_participant_index', methods: ['GET'])]
    public function index(
        Request $request,
        ParticipantRepository $participantRepository,
        PaginatorInterface $paginator
    ): Response
    {
        $queryBuilder = $participantRepository->createQueryBuilder('p');

        if ($firstName = $request->query->get('firstName')) {
            $queryBuilder->andWhere('p.firstName LIKE :firstName')->setParameter('firstName', "%$firstName%");
        }
        if ($lastName = $request->query->get('lastName')) {
            $queryBuilder->andWhere('p.lastName LIKE :lastName')->setParameter('lastName', "%$lastName%");
        }
        if ($email = $request->query->get('email')) {
            $queryBuilder->andWhere('p.email LIKE :email')->setParameter('email', "%$email%");
        }
        if ($phone = $request->query->get('phone')) {
            $queryBuilder->andWhere('p.phone LIKE :phone')->setParameter('phone', "%$phone%");
        }

        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);

        $pagination = $paginator->paginate(
            $queryBuilder,
            $page,
            $limit
        );

        return $this->render('participant/index.html.twig', [
            'pagination' => $pagination,
            'filters' => [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'limit' => $limit,
            ],
        ]);
    }
    #[Route('/new', name: 'app_participant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantForm::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($participant);
            $entityManager->flush();

            return $this->redirectToRoute('app_participant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('participant/new.html.twig', [
            'participant' => $participant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_participant_show', methods: ['GET'])]
    public function show(Participant $participant): Response
    {
        return $this->render('participant/show.html.twig', [
            'participant' => $participant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_participant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Participant $participant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParticipantForm::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_participant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('participant/edit.html.twig', [
            'participant' => $participant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_participant_delete', methods: ['POST'])]
    public function delete(Request $request, Participant $participant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participant->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($participant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_participant_index', [], Response::HTTP_SEE_OTHER);
    }
}
