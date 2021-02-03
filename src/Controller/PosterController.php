<?php

namespace App\Controller;

use App\Entity\PosterSession;
use App\Form\PosterSessionType;
use App\Repository\PosterSessionRepository;
use App\Entity\Poster;
use App\Form\PosterType;
use App\Repository\PosterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/poster")
 */
class PosterController extends AbstractController
{
    /**
     * @Route("/", name="poster_index", methods={"GET"})
     */
    public function index(PosterSessionRepository $posterSessionRepository): Response
    {
        return $this->render('poster/public.html.twig', [
            'posters' => $posterSessionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/session/", name="poster_session_index", methods={"GET"})
     * @IsGranted("ROLE_MANAGER")
     */
    public function session_index(PosterSessionRepository $posterSessionRepository): Response
    {
        return $this->render('poster_session/index.html.twig', [
            'poster_sessions' => $posterSessionRepository->findAll(),
        ]);
    }
    
    /**
     * @Route("/session/{id}/rooms", name="poster_session_room", methods={"get"})
     * @IsGranted("ROLE_MANAGER")
     */
    public function room(PosterSession $session): Response
    {
        return $this->render('poster_session/rooms.html.twig', [
            'session' => $session
        ]);
    }
    
    /**
     * @Route("/session/new", name="poster_session_new", methods={"GET","POST"})
     * @IsGranted("ROLE_MANAGER")
     */
    public function session_new(Request $request): Response
    {
        $posterSession = new PosterSession();
        $form = $this->createForm(PosterSessionType::class, $posterSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($posterSession);
            $entityManager->flush();

            return $this->redirectToRoute('poster_session_index');
        }

        return $this->render('poster_session/new.html.twig', [
            'poster_session' => $posterSession,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/session/{id}", name="poster_session_show", methods={"GET"})
     * @IsGranted("ROLE_MANAGER")
     */
    public function session_show(PosterSession $posterSession): Response
    {
        return $this->render('poster_session/show.html.twig', [
            'poster_session' => $posterSession,
        ]);
    }

    /**
     * @Route("/session/{id}/edit", name="poster_session_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_MANAGER")
     */
    public function session_edit(Request $request, PosterSession $posterSession): Response
    {
        $form = $this->createForm(PosterSessionType::class, $posterSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('poster_session_index');
        }

        return $this->render('poster_session/edit.html.twig', [
            'poster_session' => $posterSession,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/session/{id}", name="poster_session_delete", methods={"DELETE"})
     * @IsGranted("ROLE_MANAGER")
     */
    public function session_delete(Request $request, PosterSession $posterSession): Response
    {
        if ($this->isCsrfTokenValid('delete'.$posterSession->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($posterSession);
            $entityManager->flush();
        }

        return $this->redirectToRoute('poster_session_index');
    }
    
    /**
     * @Route("/manage", name="poster_manage", methods={"GET"})
     * @IsGranted("ROLE_MANAGER")
     */
    public function manage(PosterRepository $posterRepository): Response
    {
        return $this->render('poster/index.html.twig', [
            'posters' => $posterRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="poster_new", methods={"GET","POST"})
     * @IsGranted("ROLE_MANAGER")
     */
    public function new(Request $request): Response
    {
        $poster = new Poster();
        $form = $this->createForm(PosterType::class, $poster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($poster);
            $entityManager->flush();

            return $this->redirectToRoute('poster_index');
        }

        return $this->render('poster/new.html.twig', [
            'poster' => $poster,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="poster_show", methods={"GET"})
     * @IsGranted("ROLE_MANAGER")
     */
    public function show(Poster $poster): Response
    {
        return $this->render('poster/show.html.twig', [
            'poster' => $poster,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="poster_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_MANAGER")
     */
    public function edit(Request $request, Poster $poster): Response
    {
        $form = $this->createForm(PosterType::class, $poster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('poster_manage');
        }

        return $this->render('poster/edit.html.twig', [
            'poster' => $poster,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="poster_delete", methods={"DELETE"})
     * @IsGranted("ROLE_MANAGER")
     */
    public function delete(Request $request, Poster $poster): Response
    {
        if ($this->isCsrfTokenValid('delete'.$poster->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($poster);
            $entityManager->flush();
        }

        return $this->redirectToRoute('poster_index');
    }
}
