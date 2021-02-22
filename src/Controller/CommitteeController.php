<?php

namespace App\Controller;

use App\Entity\Committee;
use App\Form\CommitteeType;
use App\Repository\CommitteeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/committee")
 */
class CommitteeController extends AbstractController
{
    /**
     * @Route("/", name="committee_index", methods={"GET"})
     */
    public function index(CommitteeRepository $committeeRepository): Response
    {
        return $this->render('committee/public.html.twig', [
            'committees' => $committeeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/manage", name="committee_manage", methods={"GET"})
     * @IsGranted("ROLE_ALL_REGISTRATIONS")
     */
    public function manage(CommitteeRepository $committeeRepository): Response
    {
        return $this->render('committee/index.html.twig', [
            'committees' => $committeeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="committee_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ALL_REGISTRATIONS")
     */
    public function new(Request $request): Response
    {
        $committee = new Committee();
        $form = $this->createForm(CommitteeType::class, $committee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($committee);
            $entityManager->flush();

            return $this->redirectToRoute('committee_index');
        }

        return $this->render('committee/new.html.twig', [
            'committee' => $committee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="committee_show", methods={"GET"})
     * @IsGranted("ROLE_ALL_REGISTRATIONS")
     */
    public function show(Committee $committee): Response
    {
        return $this->render('committee/show.html.twig', [
            'committee' => $committee,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="committee_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ALL_REGISTRATIONS")
     */
    public function edit(Request $request, Committee $committee): Response
    {
        $form = $this->createForm(CommitteeType::class, $committee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('committee_index');
        }

        return $this->render('committee/edit.html.twig', [
            'committee' => $committee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="committee_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ALL_REGISTRATIONS")
     */
    public function delete(Request $request, Committee $committee): Response
    {
        if ($this->isCsrfTokenValid('delete'.$committee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($committee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('committee_index');
    }
}
