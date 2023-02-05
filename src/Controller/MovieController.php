<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/movie', name: 'movie')]
    public function index(): Response
    {
        $movies = ['Movie name 1', 'Movie name 2', 'Movie name 3', 'Movie name 4'];

        return $this->render('index.html.twig', [
            'movies' => $movies,
        ]);
    }

    #[Route('/movie1', name: 'movie1')]
    public function movie1(MovieRepository $repository): Response
    {
        $movies = $repository->findAll();
        dd($movies);

        return $this->render('index.html.twig');
    }

    #[Route('/movie2', name: 'movie2')]
    public function movie2(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(Movie::class);
        $movies = $repository->findAll();
        dd($movies);

        return $this->render('index.html.twig');
    }

    #[Route('/movie3', name: 'movie3')]
    public function movie3(): Response
    {
        $repository = $this->em->getRepository(Movie::class);

        // $movies = $repository->findAll();
        // $movies = $repository->find(1);
        // $movies = $repository->findBy(['id' => 1, 'title' => 'The Dark Knight'], ['id' => 'DESC']);
        // $movies = $repository->findBy(['id' => 2, 'title' => 'The Dark Knight'], ['id' => 'DESC']);
        // $movies = $repository->count([]);
        // $movies = $repository->count(['releaseYear' => 2008]);
        $movies = $repository->getClassName();
        dd($movies);

        return $this->render('index.html.twig');
    }
}
