<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/registration")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/list", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository, $admin = false): Response
    {
        $options = [];
        if(empty($_GET['sort'])){
            $users = $userRepository->findAll();
        } else {
            $users = $userRepository->findBy([], [$_GET['sort']=>$_GET['dir'], 'name'=>$_GET['dir'], 'email'=>$_GET['dir']]);
        }
        
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'admin' => $admin,
            'sort' => $_GET['sort'] ?? 'name',
            'dir' => $_GET['dir'] ?? 'asc',
            'stats' => $userRepository->findAllStatistics()
        ]);
    }
    /**
     * @Route("/admin", name="user_admin", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin(UserRepository $userRepository): Response
    {
        return $this->index($userRepository, true);
    }
    
    /**
     * @Route("/registrations.csv", name="user_csv")
     */
    public function csv(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        $response = $this->render('user/export.csv.twig', ['users'=>$users]);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="IMDIS2021_registration_v'.date('Ymd_His').'.csv"');
        return $response;
    }
    
    /**
     * @Route("/", name="user_self", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show_self(Request $request): Response
    {
        return $this->render('user/registration.html.twig',
            ['user' => $this->getUser()]
        );
    }

    
    /**
     * @Route("/edit", name="registration_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_USER")
     */
    public function self_edit(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_self');
        }

        return $this->render('user/edit_registration.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    
    
    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
