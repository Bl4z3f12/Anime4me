<?php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Link;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EpisodeshowController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/episode/{episodeId}/watch/{linkId}', name: 'app_episode_watch')]
    public function watch(int $episodeId, int $linkId): Response
    {
        $episode = $this->entityManager->getRepository(Episode::class)->find($episodeId);

        if (!$episode) {
            throw $this->createNotFoundException('The episode does not exist');
        }

        $link = $this->entityManager->getRepository(Link::class)->find($linkId);

        if (!$link || $link->getEpisode()->getId() !== $episodeId) {
            throw $this->createNotFoundException('The episode link does not exist');
        }

        return $this->render('animelist/watch.html.twig', [
            'episode' => $episode,
            'link' => $link,
        ]);
    }
}
