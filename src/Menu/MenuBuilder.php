<?php

namespace App\Menu;

use App\Entity\ProgramBlock;
use App\Entity\Event;
use App\Entity\PosterSession;
use App\Controller\PageController;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MenuBuilder
{
    private $factory;
    private $router;
    private $registry;
    private $auth;

    /**
     * Add any other dependency you need...
     */
    public function __construct(FactoryInterface $factory, Router $router, AuthorizationCheckerInterface $auth, $registation_status, ManagerRegistry $registry)
    {
        $this->factory = $factory;
        $this->router = $router;
        $this->registry = $registry;
        $this->auth = $auth;
        $this->registration_status = $registation_status;
    }

    public function createMainMenu(array $options): ItemInterface
    {
        return $this->doCreateMenu($options, $last_empty = true);
    }
    
    public function createFootMenu(array $options): ItemInterface
    {
        return $this->doCreateMenu($options);
    }
    
    private function doCreateMenu(array $options, $last_empty = false): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->addChild('Home', ['route' => 'index']);
        $menu->addChild('Programme', ['route' => 'program_index']);
        $uri = $this->router->generate('program_index');
        foreach($this->registry->getRepository(ProgramBlock::class)->findAll() as $block){
            $title = $block->__toString();
            $anchor = $block->getAnchor();
            $menu['Programme']->addChild($title , ['uri'=> $uri . '#' . $anchor]);
        };
        $menu->addChild('SO Decade', ['route' => 'sodecade']);
        $menu['SO Decade']->addChild('Programme', ['route' => 'program_index', 'routeParameters' => ['event' => 'sodecade']]);
        $menu['SO Decade']->addChild('Hackathons', ['route'=> 'hackathon_public', 'routeParameters' => ['event' => 'sodecade']]);
        $uri = $this->router->generate('program_index', ['event' => 'sodecade']);
        foreach($this->registry->getRepository(Event::class)->findOneBySlug('sodecade')->getProgramBlocks()  as $block){
            $title = $block->__toString();
            $anchor = $block->getAnchor();
            $menu['SO Decade']['Programme']->addChild($title , ['uri'=> $uri . '#' . $anchor]);
        };
        
        $menu->addChild('PDF IV', ['route' => 'pdfiv']);
        $menu['PDF IV']->addChild('Programme', ['route' => 'program_index', 'routeParameters' => ['event' => 'pdfiv']]);
        $uri = $this->router->generate('program_index', ['event' => 'pdfiv']);
        foreach($this->registry->getRepository(Event::class)->findOneBySlug('pdfiv')->getProgramBlocks() as $block){
            $title = $block->__toString();
            $anchor = $block->getAnchor();
            $menu['PDF IV']['Programme']->addChild($title , ['uri'=> $uri . '#' . $anchor]);
        };
        
        $menu['PDF IV']->addChild('Posters', ['route' => 'poster_index']);
        $menu['PDF IV']->addChild('Hackathons', ['route'=> 'hackathon_public', 'routeParameters' => ['event' => 'pdfiv']]);
        $uri = $this->router->generate('poster_index');
        foreach($this->registry->getRepository(PosterSession::class)->findAll() as $session){
            $title = $session->__toString();
            $anchor = $session->getAnchor();
            $menu['PDF IV']['Posters']->addChild($title , ['uri'=> $uri . '#' . $anchor]);
        };
        
        $infoLabel = 'Conference Information';
        $menu['PDF IV']->addChild($infoLabel, ['route'=>'conference_info']);
        // $menu[$infoLabel]->addChild('Abstracts', ['route'=>'imdis_abstract_index']);
        $menu['PDF IV'][$infoLabel]->addChild('Sessions', ['route'=>'theme_index']);
        $menu['PDF IV'][$infoLabel]->addChild('Access Live Sessions of Polar Data Forum IV (Zoom)', ['route'=>'zoom']);
        $menu['PDF IV'][$infoLabel]->addChild('Access Informal Sessions of Polar Data Forum IV (Wonder.me)', ['route'=>'wonderme']);
        $menu['PDF IV'][$infoLabel]->addChild('Committees', ['route'=>'committee_index']);
        $menu['PDF IV'][$infoLabel]->addChild('Contact', ['route'=>'contact']);
        
        $helpName = 'Guidelines';
        $menu['PDF IV']->addChild($helpName, ['route'=>'help_index']);
        foreach(PageController::$helppages as $id=>$label){
            $menu['PDF IV'][$helpName]->addChild($label, ['route'=>'help', 'routeParameters' => ['help' => $id]]);
        
        }
        if($this->registration_status !== 'future'){
            $menu->addChild('Registrations', ['route'=>'user_index']);
            if ($this->auth->isGranted('ROLE_USER')) {
                $menu['Registrations']->addChild('My registration', ['route'=>'user_self']);
            }
        }
        
        if ($this->auth->isGranted('ROLE_EDIT_PROGRAM') && false) {
            $menu->addChild('Admin', ['route'=>'admin']);
            $menu['Admin']->addChild('Registrations', ['route'=>'user_index']);
            $menu['Admin']->addChild('Edit Abstracts', ['route'=>'imdis_abstract_manage']);
            $menu['Admin']->addChild('Edit program', ['route'=>'program_block_index']);
            $menu['Admin']->addChild('Edit posters', ['route'=>'poster_manage']);
            
        }
        if($last_empty){
            $menu->addChild('');//empty last item needed for correct menu rendering
        }
        return $menu;
    }
    
    public function createLegalMenu(array $options) :ItemInterface
    {
        $menu = $this->factory->createItem('root');
        foreach(PageController::$termspages as $id=>$label){
            $menu->addChild($label, ['route'=>'terms', 'routeParameters' => ['terms' => $id]]);
        
        }
        return $menu;
    }
}
