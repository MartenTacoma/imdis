<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PageController extends AbstractController
{
    public static $termspages = [
        'conditions' => 'Privacy & Terms',
        'cookies' => 'Cookie Policy',
        'codeofconduct' => 'Code of Conduct',
    ];
    public static $helppages = [
        'zoom' => 'Zoom',
        'poster' => 'Poster presentations',
        'oral' => 'Oral presentations',
        'video' => 'Making a video presentation'
    ];
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->redirectToRoute('program_index');
        // return $this->render('page/index.html.twig');
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
     * @Route("/help/{help}", name="help")
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
     * @Route("/help", name="help_index")
     */
    public function help_index(): Response
    {
        return $this->render(
            'page/menu.html.twig',
            [
                'pagetitle' => 'Help',
                'menu' => ['main', 'Conference info', 'Help']
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
                'pagetitle' => 'Conference info'
            ]
        );
    }
    
    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_MANAGER")
     */
    public function admin(): Response
    {
        return $this->render(
            'page/menu.html.twig',
            [
                'pagetitle' => 'Admin'
            ]
        );
    }
    
    // /**
    //  * @Route("/p/{page}", name="menupage")
    //  */
    // public function menu($page): Response
    // {
    //     return $this->render(
    //         'page/menu.html.twig',
    //         [
    //             'pagetitle' => ucfirst($page)
    //         ]
    //     );
    // }
}
