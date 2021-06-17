<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\UserRepository;
use App\Repository\ThemeRepository;
use App\Repository\ImdisAbstractRepository;
use App\Repository\ProgramBlockRepository;

class PageController extends AbstractController
{
    public static $termspages = [
        'conditions' => 'Privacy & Terms',
        'cookies' => 'Cookie Policy',
        'codeofconduct' => 'Code of Conduct',
        'credits' => 'Copyright & Credits'
    ];
    public static $helppages = [
        'poster' => 'Poster Presentations',
        'oral' => 'Oral Presentations',
        'video' => 'Making a Video for Posters & Oral presentations'
    ];
    
    /**
     * @Route("/", name="index")
     */
    public function index(UserRepository $users, ThemeRepository $themes, ImdisAbstractRepository $abstracts, ProgramBlockRepository $program): Response
    {
        if($this->getParameter('app.dashboard') && $this->isGranted($this->getParameter('app.dashboard_role'))){
            return $this->render('page/dashboard.html.twig', [
                'users' => $users->findAllStatistics(),
                'themes' => $themes->findAll(),
                'abstracts' => $abstracts->findAll(),
                'program' => $program->findOneByCurrentOrNext()
            ]);
        } else {
            return $this->render('page/index.html.twig', [
                'users' => $users->findAllStatistics(),
                'themes' => $themes->findAll(),
                'abstracts' => $abstracts->findAll()
            ]);
        }
    }
    
    /**
     * @Route("/terms/{terms}", name="terms")
     */
    public function terms($terms): Response
    {
        
        return $this->render(
            'page/terms.html.twig',
            [
                'terms' => $terms,
                'pagetitle' => self::$termspages[$terms]
            ]
        );
    }
    
    /**
     * @Route("/zoom", name="zoom")
     */
    public function zoom(): Response
    {
        return $this->render(
            'page/zoom.html.twig'
        );
    }
    
    /**
     * @Route("/wonder.me", name="wonderme")
     */
    public function wonderme(): Response
    {
        return $this->render(
            'page/wonder.me.html.twig'
        );
    }
    
    /**
     * @Route("/chrome", name="chrome")
     */
    public function chrome(): Response
    {
        return $this->render(
            'page/chrome.html.twig'
        );
    }
    
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render(
            'page/contact.html.twig'
        );
    }
    
    /**
     * @Route("/guidelines/{help}", name="help")
     */
    public function help($help): Response
    {
        
        return $this->render(
            'page/help.html.twig',
            [
                'help' => $help,
                'pagetitle' => self::$helppages[$help]
            ]
        );
    }
    
    /**
     * @Route("/guidelines", name="help_index")
     */
    public function help_index(): Response
    {
        return $this->render(
            'page/menu.html.twig',
            [
                'pagetitle' => 'Guidelines',
                'menu' => ['main', 'PDF IV', 'Guidelines']
            ]
        );
    }
    
    /**
     * @Route("/conference", name="conference_info")
     */
    public function conference(): Response
    {
        return $this->render(
            'page/menu.html.twig',
            [
                'pagetitle' => 'Conference Information',
                'menu' => ['main', 'PDF IV', 'Conference Information']
            ]
        );
    }
    
    /**
     * @Route("/sodecade", name="sodecade")
     */
    public function sodecade(): Response
    {
        return $this->render(
            'page/sodecade.html.twig',
            [
                'pagetitle' => 'Southern Ocean Decade Workshop'
            ]
        );
    }
    
    /**
     * @Route("/pdfiv", name="pdfiv")
     */
    public function pdfiv(): Response
    {
        return $this->render(
            'page/pdf.html.twig',
            [
                'pagetitle' => 'Polar Data Forum IV'
            ]
        );
    }
}
