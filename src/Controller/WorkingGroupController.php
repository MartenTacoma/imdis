<?php

namespace App\Controller;

use App\Entity\WorkingGroup;
use App\Form\WorkingGroupType;
use App\Repository\WorkingGroupRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/wg")
 */
class WorkingGroupController extends AbstractController
{
    /**
     * @Route("/manage", name="wg_index", methods={"GET"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function manage(WorkingGroupRepository $wgRepository): Response
    {
        return $this->render('wg/index.html.twig', [
            'wgs' => $wgRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="wg_new", methods={"GET","POST"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function new(Request $request): Response
    {
        $wg = new WorkingGroup();
        $form = $this->createForm(WorkingGroupType::class, $wg);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($wg);
            $entityManager->flush();

            return $this->redirectToRoute('wg_index');
        }

        return $this->render('wg/new.html.twig', [
            'wg' => $wg,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="wg_show", methods={"GET"})
     */
    public function show(WorkingGroup $wg): Response
    {
        return $this->render('wg/show.html.twig', [
            'wg' => $wg,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="wg_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function edit(Request $request, WorkingGroup $wg): Response
    {
        $form = $this->createForm(WorkingGroupType::class, $wg);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wg_index');
        }

        return $this->render('wg/edit.html.twig', [
            'wg' => $wg,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wg_delete", methods={"POST"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function delete(Request $request, WorkingGroup $wg): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wg->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($wg);
            $entityManager->flush();
        }

        return $this->redirectToRoute('wg_index');
    }
    
    /**
     * @Route("/", name="wg_public_all", methods={"GET"})
     * @Route("/list/{event}", name="wg_public", methods={"GET"})
     */
    public function index(WorkingGroupRepository $wgRepository, EventRepository $eventRepository, $event=null): Response
    {
        if (empty($event)){
            return $this->render('wg/public.html.twig', [
                'wgs' => $wgRepository->findAll(),
            ]);
        } else {
            $event = $eventRepository->findOneBySlug($event);
            if (empty($event)){
                throw $this->createNotFoundException();
            }
            
            return $this->render('wg/public.html.twig', [
                'title' => 'Working Groups - ' . $event->getName(),
                'wgs' => $event->getWorkingGroups(),
            ]);
        }
    }
}
