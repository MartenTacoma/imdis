<?php

namespace App\Controller;

use App\Entity\ImdisAbstract;
use App\Form\ImdisAbstractType;
use App\Repository\ImdisAbstractRepository;
use App\Repository\ThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/abstract")
 */
class ImdisAbstractController extends AbstractController
{
    /**
     * @Route("/", name="imdis_abstract_index", methods={"GET"})
     */
    public function index(ThemeRepository $themeRepository): Response
    {
        return $this->render('imdis_abstract/public.html.twig', [
            'themes' => $themeRepository->findAll(),
        ]);
    }
    
    /**
     * @Route("/manage", name="imdis_abstract_manage", methods={"GET"})
     * @IsGranted("ROLE_MANAGER")
     */
    public function manage(ImdisAbstractRepository $imdisAbstractRepository): Response
    {
        return $this->render('imdis_abstract/index.html.twig', [
            'imdis_abstracts' => $imdisAbstractRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="imdis_abstract_new", methods={"GET","POST"})
     * @IsGranted("ROLE_MANAGER")
     */
    public function new(Request $request): Response
    {
        $imdisAbstract = new ImdisAbstract();
        $form = $this->createForm(ImdisAbstractType::class, $imdisAbstract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($imdisAbstract);
            $entityManager->flush();

            return $this->redirectToRoute('imdis_abstract_index');
        }

        return $this->render('imdis_abstract/new.html.twig', [
            'imdis_abstract' => $imdisAbstract,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="imdis_abstract_show", methods={"GET"})
     */
    public function show(ImdisAbstract $imdisAbstract): Response
    {
        return $this->render('imdis_abstract/show.html.twig', [
            'imdis_abstract' => $imdisAbstract,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="imdis_abstract_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_MANAGER")
     */
    public function edit(Request $request, ImdisAbstract $imdisAbstract): Response
    {
        $form = $this->createForm(ImdisAbstractType::class, $imdisAbstract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('imdis_abstract_manage');
        }

        return $this->render('imdis_abstract/edit.html.twig', [
            'imdis_abstract' => $imdisAbstract,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="imdis_abstract_delete", methods={"DELETE"})
     * @IsGranted("ROLE_MANAGER")
     */
    public function delete(Request $request, ImdisAbstract $imdisAbstract): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imdisAbstract->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($imdisAbstract);
            $entityManager->flush();
        }

        return $this->redirectToRoute('imdis_abstract_index');
    }
}
