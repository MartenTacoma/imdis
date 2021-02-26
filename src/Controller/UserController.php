<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\RegistrationFormType;
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
    public static $roles = [
        'Admin' => 'ROLE_ADMIN',
        'View all registrations' => 'ROLE_ALL_REGISTRATIONS',
        'Edit programme details' => 'ROLE_EDIT_PROGRAM',
        'View presentation consent lists' => 'ROLE_CONSENT'
    ];
    
    
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
        
        $colors = [
            'min' => [
                'r'=> 143,
                'g'=> 192,
                'b'=> 245
            ],
            'max' => [
                'r'=> 9,
                'g'=> 53,
                'b'=> 100
            ]
        ];
        $countries = $userRepository->findAllCountries();
        $counts = [];
        foreach($countries as $country){
            if(array_key_exists($country['registrations'], $counts)){
                $counts[$country['registrations']]++;
            } else {
                $counts[$country['registrations']] = 1;
            }
        }
        ksort($counts);
        $maxRegs = max(array_keys($counts));
        $bins = [];
        $map = [];
        $prev = 0;
        for($i = 1;$i <= 5; $i++){
            if(count($counts) == 0){
                break;
            }
            $r = array_sum($counts);
            $aim = floor($r / (6 - $i));
            $bins[$i] = ['start' => $prev+1, 'n'=>0, '$aim'=>$aim];
            foreach($counts as $n=>$c){
                $map[$n] = $i;
                $aim -= $c;
                $bins[$i]['n'] += $c;
                unset($counts[$n]);
                if($aim <= 0){
                    $bins[$i]['end'] = $n;
                    $prev = $n;
                    break;
                }
            }
        }
        $bins[$i-1]['end'] = $n;
        $colorscale = [];
        if(count($bins) == 1 || !$admin){
            $factor = 0.5;
            $i = 1;
            $colorscale[$i] = 'rgb('
                . ( $colors['min']['r'] + $factor * ($colors['max']['r'] - $colors['min']['r']) ) . ', '
                . ( $colors['min']['g'] + $factor * ($colors['max']['g'] - $colors['min']['g']) ) . ', '
                . ( $colors['min']['b'] + $factor * ($colors['max']['b'] - $colors['min']['b']) ) . ')';
            $bin = $bins[1];
            $limits[$i] = $bin['start'] . ($bin['start'] == $bin['end'] ? '' : ' - '.$bin['end']);
            foreach($countries as &$country){
                $country['color'] = $colorscale[$i];
                $country['color2'] = $colorscale[$i];
                $color = [
                    'r' => ($colors['min']['r']+$colors['max']['r'])/2,
                    'g' => ($colors['min']['g']+$colors['max']['g'])/2,
                    'b' => ($colors['min']['b']+$colors['max']['b'])/2
                ];
                $colors = ['min' => $color, 'max' => $color];
            }    
        } else {
            foreach($bins as $i=>$bin){
                $factor = ($i - 1) / (count($bins) - 1);
                $colorscale[$i] = 'rgb('
                    . ( $colors['min']['r'] + $factor * ($colors['max']['r'] - $colors['min']['r']) ) . ', '
                    . ( $colors['min']['g'] + $factor * ($colors['max']['g'] - $colors['min']['g']) ) . ', '
                    . ( $colors['min']['b'] + $factor * ($colors['max']['b'] - $colors['min']['b']) ) . ')';
                $limits[$i] = $bin['start'] . ($bin['start'] == $bin['end'] ? '' : ' - '.$bin['end']);
            }
            foreach($countries as &$country){
                $country['color'] =  $colorscale[$map[$country['registrations']]];
                $factor = log10($country['registrations']) / log10($maxRegs);
                $country['color'] = 'rgb('
                . ( $colors['min']['r'] + $factor * ($colors['max']['r'] - $colors['min']['r']) ) . ', '
                . ( $colors['min']['g'] + $factor * ($colors['max']['g'] - $colors['min']['g']) ) . ', '
                . ( $colors['min']['b'] + $factor * ($colors['max']['b'] - $colors['min']['b']) ) . ')';
            }
        }
        $labels = [1=>0, $maxRegs=>1];
        if($maxRegs > 1){
            $marks = [1/4, 1/2, 3/4];
            foreach ($marks as $mark){
                $label = round(pow(10, $mark * log10($maxRegs)));
                $labels[$label] = log10($label) / log10($maxRegs);
            }
        }
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'admin' => $admin,
            'maxRegs' => $maxRegs,
            'sort' => $_GET['sort'] ?? 'name',
            'dir' => $_GET['dir'] ?? 'asc',
            'stats' => $userRepository->findAllStatistics(),
            'countries' => $countries,
            'colorscale' => $colorscale,
            'colors' => $colors,
            'limits' => $limits,
            'labels' => $labels
        ]);
    }
    /**
     * @Route("/admin", name="user_admin", methods={"GET"})
     * @IsGranted("ROLE_ALL_REGISTRATIONS")
     */
    public function admin(UserRepository $userRepository): Response
    {
        return $this->index($userRepository, true);
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
        $form->get('registrationType')->setData($user->getRegistrationType());
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
