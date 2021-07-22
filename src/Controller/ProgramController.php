<?php

namespace App\Controller;

use App\Entity\ProgramSession;
use App\Form\ProgramSessionType;
use App\Repository\ProgramSessionRepository;
use App\Entity\ProgramBlock;
use App\Form\ProgramBlockType;
use App\Repository\ProgramBlockRepository;
use App\Entity\Presentation;
use App\Form\PresentationType as PresentationForm;
use App\Repository\PresentationRepository;
use App\Repository\EventRepository;
use App\Entity\PresentationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/programme")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("/consent", name="presentation_consent", methods={"GET"})
     * @IsGranted("ROLE_CONSENT");
     */
    public function presentation_consent(ProgramBlockRepository $programBlockRepository): Response
    {
        return $this->render('program/consent.html.twig', [
            'talks' => $programBlockRepository->findAll(),
        ]);
    }
    /**
     * @Route("/consent.csv", name="presentation_consent_csv", methods={"GET"})
     * @IsGranted("ROLE_CONSENT");
     */
    public function presentation_consent_csv(PresentationRepository $presentationRepository): Response
    {
        $response = $this->render('program/consent.csv.twig', [
            'talks' => $presentationRepository->findByConsent(),
        ]);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="WORKINGNAME_poster_consent_v'.date('Ymd_His').'.csv"');
        return $response;
    }
    
    /**
     * @Route("/manage/", name="program_block_index", methods={"GET"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function block_index(ProgramBlockRepository $programBlockRepository): Response
    {
        return $this->render('program/index.html.twig', [
            'program_blocks' => $programBlockRepository->findAll(),
        ]);
    }

    /**
     * @Route("/block/new", name="program_block_new", methods={"GET","POST"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function block_new(Request $request): Response
    {
        $programBlock = new ProgramBlock();
        $form = $this->createForm(ProgramBlockType::class, $programBlock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($programBlock);
            $entityManager->flush();

            return $this->redirectToRoute('program_block_index');
        }

        return $this->render('program/new.html.twig', [
            'program_block' => $programBlock,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/block/{id}", name="program_block_show", methods={"GET"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function block_show(ProgramBlock $programBlock): Response
    {
        return $this->render('program/show.html.twig', [
            'program_block' => $programBlock,
        ]);
    }

    /**
     * @Route("/block/{id}/edit", name="program_block_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function block_edit(Request $request, ProgramBlock $programBlock): Response
    {
        $form = $this->createForm(ProgramBlockType::class, $programBlock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('program_block_index');
        }

        return $this->render('program/edit.html.twig', [
            'program_block' => $programBlock,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/block/{id}", name="program_block_delete", methods={"DELETE"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function block_delete(Request $request, ProgramBlock $programBlock): Response
    {
        if ($this->isCsrfTokenValid('delete'.$programBlock->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($programBlock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('program_block_index');
    }
    
    /**
     * @Route("/block/{id}/session", name="program_block_session", methods={"GET","POST"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function session_block_new(Request $request, ProgramBlock $programBlock): Response
    {
        $programSession = new ProgramSession();
        $programSession->setBlock($programBlock);
        $form = $this->createForm(ProgramSessionType::class, $programSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($programSession);
            $entityManager->flush();

            return $this->redirectToRoute('program_session_show', ['id' => $programSession->getId()]);
        }

        return $this->render('program_session/new.html.twig', [
            'program_session' => $programSession,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/session/{id}", name="program_session_show", methods={"GET"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function session_show(ProgramSession $programSession): Response
    {
        return $this->render('program_session/show.html.twig', [
            'program_session' => $programSession,
        ]);
    }

    /**
     * @Route("/session/{id}/edit", name="program_session_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function session_edit(Request $request, ProgramSession $programSession): Response
    {
        $form = $this->createForm(ProgramSessionType::class, $programSession);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('program_session_show', ['id' => $programSession->getId()]);
        }

        return $this->render('program_session/edit.html.twig', [
            'program_session' => $programSession,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/session/{id}", name="program_session_delete", methods={"DELETE"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function session_delete(Request $request, ProgramSession $programSession): Response
    {
        if ($this->isCsrfTokenValid('delete'.$programSession->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($programSession);
            $entityManager->flush();
        }

        return $this->redirectToRoute('program_block_show', ['id' => $programSession->getBlock()->getId()]);
    }
    
        /**
     * @Route("/session/{id}/presentation", name="presentation_new", methods={"GET","POST"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function new(Request $request, ProgramSession $programSession): Response
    {
        $presentation = new Presentation();
        $presentation->setProgramSession($programSession);
        $form = $this->createForm(PresentationForm::class, $presentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($presentation);
            $entityManager->flush();

            return $this->redirectToRoute('program_session_show', ['id' => $programSession->getId()]);
        }
        
        $repository = $this->getDoctrine()->getRepository(PresentationType::class);
        
        $types = $repository->findAll();
        
        return $this->render('presentation/new.html.twig', [
            'presentation' => $presentation,
            'form' => $form->createView(),
            'types' => $types
        ]);
    }
    
        /**
     * @Route("/presentation/{id}/edit", name="presentation_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function edit(Request $request, Presentation $presentation): Response
    {
        $form = $this->createForm(PresentationForm::class, $presentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('program_index');
        }

        $repository = $this->getDoctrine()->getRepository(PresentationType::class);
        
        $types = $repository->findAll();
        
        return $this->render('presentation/edit.html.twig', [
            'presentation' => $presentation,
            'form' => $form->createView(),
            'types' => $types
        ]);
    }

    /**
     * @Route("/presentation/{id}", name="presentation_delete", methods={"DELETE"})
     * @IsGranted("ROLE_EDIT_PROGRAM")
     */
    public function delete(Request $request, Presentation $presentation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$presentation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($presentation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('program_session_show', ['id' => $presentation->getProgramSession()->getId()]);
    }
    
    
    
    /**
     * @Route("/{block}.ics", name="block_ics", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function program_block_ics(
        ProgramBlockRepository $programBlockRepository,
        EventRepository $eventRepository,
        $block
    ){
        $parts = explode('_', $block);
        preg_match('((?P<year>[0-9]{4})(?P<month>[0-9]{2})(?P<day>[0-9]{2})(?P<hour>[0-9]{2})(?P<minute>[0-9]{2}))', $parts[0], $time);
        array_shift($parts);
        $programBlock = $programBlockRepository->findOneByAnchor(
            $time['year'] . '-' . $time['month'] . '-' . $time['day'],
            $time['hour'] . ':' . $time['minute'],
            $parts
        );
        $response = $this->render('program/calendar.ics.twig', ['block'=>$programBlock]);
        $response->headers->set('Content-Type', 'text/calendar');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $block . '.ics"');
        return $response;
    }
    
    /**
     * @Route("/overview/{event}", name="program_index", methods={"GET"})
     * @Route("/", name="program_index_short", methods={"GET"})
     */
    public function program_index(
        ProgramBlockRepository $programBlockRepository,
        EventRepository $eventRepository,
        $event = null
    ){
        if(empty($event)){
            return $this->render(
                'program/public.html.twig',
                [
                    'program' => $programBlockRepository->findAll(),
                    'intro' => 'Welcome to Southern Ocean Decade & Polar Data Forum Week 2021. Southern Ocean Decade & Polar Data Forum Week 2021 is entirely online.'
                ]
            );
        } else {
            $event = $eventRepository->findOneBySlug($event);
            if (empty($event)){
                throw $this->createNotFoundException();
            }
            return $this->render(
                'program/public.html.twig',
                [
                    'title' => 'Programme - ' . $event->getName(),
                    'program' => $event->getProgramBlocks(),
                    'event' => $event,
                    'intro' => $event->getIntroProgram()
                ]
            );
        }
    }
}
