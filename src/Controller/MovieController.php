<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieFormType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    private $em;
    private $movieRepository;

    public function __construct(MovieRepository $movieRepository, EntityManagerInterface $em)
    {
        $this->movieRepository = $movieRepository;
        $this->em = $em;
    }

    #[Route('/movies', methods: ['GET'], name: 'movies')]
    public function index(): Response
    {
        $movies = $this->movieRepository->findAll();

        return $this->render('movies/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    #[Route('/movies/create', methods: ['GET', 'POST'], name: 'create_movie')]
    public function create(Request $request): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieFormType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movie = $form->getData();
            $imagePath = $form->get('imagePath')->getData();

            if ($imagePath) {
                $imageFileName = uniqid() . '.' . $imagePath->guessExtension();

                try {
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads',
                        $imageFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }

                $movie->setImagePath('/uploads/' . $imageFileName);
            }

            $this->em->persist($movie);
            $this->em->flush();

            return $this->redirectToRoute('movies');
        }

        return $this->render('movies/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/movies/{id}', methods: ['GET'], name: 'show_movie')]
    public function movies($id): Response
    {
        $movie = $this->movieRepository->find($id);

        return $this->render('movies/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/movies/{id}/edit', methods: ['GET', 'POST'], name: 'edit_movie')]
    public function edit(Request $request, $id): Response
    {
        $movie = $this->movieRepository->find($id);
        $form = $this->createForm(MovieFormType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagePath = $form->get('imagePath')->getData();

            if ($imagePath) {
                $imageFileName = uniqid() . '.' . $imagePath->guessExtension();

                try {
                    $oldImagePath = $movie->getImagePath();
                    $publicPath = $this->getParameter('public_dir');

                    if (
                        $oldImagePath !== null &&
                        file_exists($publicPath . $oldImagePath)
                    ) {
                        $filesystem = new Filesystem();
                        $filesystem->remove([$publicPath . $oldImagePath]);
                    }

                    $imagePath->move(
                        $publicPath . '/uploads',
                        $imageFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }

                $movie->setImagePath('/uploads/' . $imageFileName);
            }

            $movie->setTitle($form->get('title')->getData());
            $movie->setReleaseYear($form->get('releaseYear')->getData());
            $movie->setDescription($form->get('description')->getData());

            $this->em->flush();

            return $this->redirectToRoute('movies');
        }

        return $this->render('movies/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/movies/{id}/delete', methods: ['GET'], name: 'delete_movie')]
    public function delete($id): Response
    {
        $movie = $this->movieRepository->find($id);

        try {
            $oldImagePath = $movie->getImagePath();
            $publicPath = $this->getParameter('public_dir');

            if (
                $oldImagePath !== null &&
                file_exists($publicPath . $oldImagePath)
            ) {
                $filesystem = new Filesystem();
                $filesystem->remove([$publicPath . $oldImagePath]);
            }
        } catch (FileException $e) {
            return new Response($e->getMessage());
        }

        $this->em->remove($movie);
        $this->em->flush();

        return $this->redirectToRoute('movies');
    }
}
