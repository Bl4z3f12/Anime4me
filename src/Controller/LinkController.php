<?php

namespace App\Controller;

use App\Entity\Link;
use App\Form\LinkType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/link')]
class LinkController extends AbstractController
{
    #[Route('/', name: 'app_link_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $links = $entityManager
            ->getRepository(Link::class)
            ->findAll();

        return $this->render('link/index.html.twig', [
            'links' => $links,
        ]);
    }

    #[Route('/new', name: 'app_link_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $link = new Link();
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($link);
            $entityManager->flush();

            return $this->redirectToRoute('app_link_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('link/new.html.twig', [
            'link' => $link,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_link_show', methods: ['GET'])]
    public function show(Link $link): Response
    {
        return $this->render('link/show.html.twig', [
            'link' => $link,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_link_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Link $link, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_link_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('link/edit.html.twig', [
            'link' => $link,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_link_delete', methods: ['POST'])]
    public function delete(Request $request, Link $link, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$link->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($link);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_link_index', [], Response::HTTP_SEE_OTHER);
    }
}
