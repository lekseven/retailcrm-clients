<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Client;
use App\Form\ClientType;
use App\Pagination\Paginator;
use App\Repository\ActivityLogRepository;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client_index", defaults={"page": "1"}, methods={"GET"})
     * @Route("/page/{page<[1-9]\d*>}", methods="GET", name="client_index_paginated")
     */
    public function index(Request $request, int $page, ClientRepository $clients): Response
    {
        $qb = $clients->createQueryBuilder('c')->addOrderBy('c.id', 'ASC');

        return $this->render('client/index.html.twig', [
            'paginator' => (new Paginator($qb))->paginate($page),
        ]);
    }

    /**
     * @Route("/new", name="client_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/new.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="client_show", methods={"GET"})
     */
    public function show(Client $client, ActivityLogRepository $activityLog): Response
    {
        $entities[] = $client;
        foreach ($client->getAddresses() as $address) {
            $entities[] = $address;
        }

        $history = $activityLog->findByEntities($entities);

        return $this->render('client/show.html.twig', [
            'client' => $client,
            'history' => $history,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Client $client): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="client_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Client $client): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_index');
    }
}
