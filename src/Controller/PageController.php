<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('page/index.html.twig', [
            
        ]);
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
