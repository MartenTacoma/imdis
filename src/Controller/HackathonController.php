<?php

namespace App\Controller;

use App\Entity\Hackathon;
use App\Form\HackathonType;
use App\Repository\HackathonRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/hackathon")
 */
class HackathonController extends AbstractController
{
    /**
     * @Route("/{event}", name="hackathon_public", methods={"GET"}, requirements={"event"="pdfiv|sodecade"})
     */
    public function index(HackathonRepository $hackathonRepository, EventRepository $eventRepository, $event=null): Response
    {
        if (empty($event)){
            return $this->render('hackathon/public.html.twig', [
                'hackathons' => $hackathonRepository->findAll(),
            ]);
        } else {
            $event = $eventRepository->findOneBySlug($event);
            return $this->render('hackathon/public.html.twig', [
                'title' => 'Hackathons - ' . $event->getName(),
                'hackathons' => $event->getHackathons(),
            ]);
        }
    }
    
    
    /**
     * @Route("/manage", name="hackathon_index", methods={"GET"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function manage(HackathonRepository $hackathonRepository): Response
    {
        return $this->render('hackathon/index.html.twig', [
            'hackathons' => $hackathonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="hackathon_new", methods={"GET","POST"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function new(Request $request): Response
    {
        $hackathon = new Hackathon();
        $form = $this->createForm(HackathonType::class, $hackathon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hackathon);
            $entityManager->flush();

            return $this->redirectToRoute('hackathon_index');
        }

        return $this->render('hackathon/new.html.twig', [
            'hackathon' => $hackathon,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="hackathon_show", methods={"GET"})
     */
    public function show(Hackathon $hackathon): Response
    {
        return $this->render('hackathon/show.html.twig', [
            'hackathon' => $hackathon,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="hackathon_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function edit(Request $request, Hackathon $hackathon): Response
    {
        $form = $this->createForm(HackathonType::class, $hackathon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hackathon_index');
        }

        return $this->render('hackathon/edit.html.twig', [
            'hackathon' => $hackathon,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hackathon_delete", methods={"POST"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function delete(Request $request, Hackathon $hackathon): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hackathon->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hackathon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hackathon_index');
    }
}
