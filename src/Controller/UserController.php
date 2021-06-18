<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Repository\EventRepository;
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
    public static $roles = [
        'Admin' => 'ROLE_ADMIN',
        'View all registrations' => 'ROLE_ALL_REGISTRATIONS',
        'Edit programme details' => 'ROLE_EDIT_PROGRAM',
        'View presentation consent lists' => 'ROLE_CONSENT'
    ];
    
    /**
     * @Route("/{event}/", name="user_index", methods={"GET"}, requirements={"event"="list|pdfiv|sodecade"})
     */
    public function index(UserRepository $userRepository, EventRepository $eventRepository, $admin = false, $event='list'): Response
    {
        $sort = empty($_GET['sort']) ? [] : [$_GET['sort']=>$_GET['dir']];
        $sort['name'] = $_GET['dir'] ?? 'asc';
        $sort['email'] = $_GET['dir'] ?? 'asc';
        if($event == 'list'){
            $users = $userRepository->findBy([], $sort);
            $event = null;
        } else {
            $event = $eventRepository->findOneBySlug($event);
            $users = $userRepository->findByEvent($event, $sort);
        }
        $this->countries = $userRepository->findAllCountries($event);
        $this->map();
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'admin' => $admin,
            'sort' => $_GET['sort'] ?? 'name',
            'dir' => $_GET['dir'] ?? 'asc',
            'stats' => $userRepository->findAllStatistics($event),
            'countries' => $this->countries,
            'colors' => $this->colors ?? [],
            'labels' => $this->labels ?? [],
            'event' => empty($event) ? 'Southern Ocean Decade & Polar Data Forum Week 2021' : $event->getName()
        ]);
    }
    /**
     * @Route("/admin", name="user_admin", methods={"GET"})
     * @IsGranted("ROLE_ALL_REGISTRATIONS")
     */
    public function admin(UserRepository $userRepository, EventRepository $eventRepository): Response
    {
        return $this->index($userRepository, $eventRepository, true);
    }
    
    /**
     * @Route("/countries", name="user_countries", methods={"GET"})
     */
    function user_countries(UserRepository $userRepository): Response
    {
        $this->countries = $userRepository->findAllCountries();
        $this->map();
        return $this->render('user/statistics.html.twig', [
            'stats' => $userRepository->findAllStatistics(),
            'countries' => $this->countries,
            'colors' => $this->colors ?? [],
            'labels' => $this->labels ?? []
        ]);
    }
    
    private function map(){
        $this->colors = [
            'min' => [
                'r'=> 0,
                'g'=> 167,
                'b'=> 217
            ],
            'max' => [
                'r'=> 2,
                'g'=> 92,
                'b'=> 109
            ]
        ];
        $counts = [];
        foreach($this->countries as $country){
            if(array_key_exists($country['registrations'], $counts)){
                $counts[$country['registrations']]++;
            } else {
                $counts[$country['registrations']] = 1;
            }
        }
        ksort($counts);
        if(count($counts) > 0){
            $maxRegs = max(array_keys($counts));
            if($maxRegs == 1){
                foreach($this->countries as &$country){
                    $color = [
                        'r' => ($this->colors['min']['r']+$this->colors['max']['r'])/2,
                        'g' => ($this->colors['min']['g']+$this->colors['max']['g'])/2,
                        'b' => ($this->colors['min']['b']+$this->colors['max']['b'])/2
                    ];
                    $country['color'] = 'rgb(' . $color['r'] . ', ' . $color['g'] . ', ' . $color['b'] . ')';
                    $this->colors = ['min' => $color, 'max' => $color];
                }    
            } else {
                foreach($this->countries as &$country){
                    $factor = log10($country['registrations']) / log10($maxRegs);
                    $country['color'] = 'rgb('
                    . ( $this->colors['min']['r'] + $factor * ($this->colors['max']['r'] - $this->colors['min']['r']) ) . ', '
                    . ( $this->colors['min']['g'] + $factor * ($this->colors['max']['g'] - $this->colors['min']['g']) ) . ', '
                    . ( $this->colors['min']['b'] + $factor * ($this->colors['max']['b'] - $this->colors['min']['b']) ) . ')';
                }
            }
            $this->labels = [1=>0, $maxRegs=>1];
            if($maxRegs > 1){
                $marks = [1/4, 1/2, 3/4];
                foreach ($marks as $mark){
                    $label = round(pow(10, $mark * log10($maxRegs)));
                    $this->labels[$label] = log10($label) / log10($maxRegs);
                }
            }
        }
    }
    
    /**
     * @Route("/registrations.csv", name="user_csv")
     * @IsGranted("ROLE_ALL_REGISTRATIONS")
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
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->remove('agreeTerms')->remove('plainPassword');
        // $form->get('registrationType')->setData($user->getRegistrationType());
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
     * @IsGranted("ROLE_ALL_REGISTRATIONS")
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
     * @IsGranted("ROLE_ALL_REGISTRATIONS")
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ALL_REGISTRATIONS")
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_admin');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ALL_REGISTRATIONS")
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
