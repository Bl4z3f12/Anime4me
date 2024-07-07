<?php

namespace App\Controller;

use App\Repository\AnimeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimelistController extends AbstractController
{
    private AnimeRepository $animeRepository;

    public function __construct(AnimeRepository $animeRepository)
    {
        $this->animeRepository = $animeRepository;
    }

    #[Route('/animelist', name: 'app_animelist')]
    public function index(): Response
    {
        $animes = $this->animeRepository->findAll();

        return $this->render('animelist/index.html.twig', [
            'animes' => $animes,
        ]);
    }

    #[Route('/anime/{id}', name: 'app_anime_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $anime = $this->animeRepository->find($id);

        if (!$anime) {
            throw $this->createNotFoundException('The anime does not exist');
        }

        return $this->render('animelist/show.html.twig', [
            'anime' => $anime,
            'episodes' => $anime->getEpisodes(),
        ]);
    }
}
