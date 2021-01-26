<?php

namespace App\Menu;

use App\Entity\ProgramBlock;
use App\Entity\PosterSession;
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
    public function __construct(FactoryInterface $factory, Router $router, AuthorizationCheckerInterface $auth, ManagerRegistry $registry)
    {
        $this->factory = $factory;
        $this->router = $router;
        $this->registry = $registry;
        $this->auth = $auth;
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
        $menu->addChild('IMDIS', ['uri' => 'https://imdis.seadatanet.org/']);
        $menu['IMDIS']->setLinkAttribute('target', '_blank');
        
        $menu->addChild('Program', ['route' => 'program_index']);
        $uri = $this->router->generate('program_index');
        foreach($this->registry->getRepository(ProgramBlock::class)->findAll() as $block){
            $title = $block->__toString();
            $anchor = $block->getDate()->format('Ymd') . 
                $block->getTimeStart()->format('Hi');
            $menu['Program']->addChild($title , ['uri'=> $uri . '#' . $anchor]);
        };
        
        $menu->addChild('Posters', ['route' => 'poster_index']);
        $uri = $this->router->generate('poster_index');
        foreach($this->registry->getRepository(PosterSession::class)->findAll() as $session){
            $title = $session->__toString();
            $anchor = $session->getDate()->format('Ymd') . 
                $session->getTimeStart()->format('Hi');
            $menu['Posters']->addChild($title , ['uri'=> $uri . '#' . $anchor]);
        };
        
        $infoLabel = 'Conference info';
        $menu->addChild($infoLabel, ['route'=>'conference_info']);
        
        $menu[$infoLabel]->addChild('Sessions', ['route'=>'theme_index']);
        
        $menu[$infoLabel]->addChild('Abstracts', ['route'=>'imdis_abstract_index']);
        
        $menu[$infoLabel]->addChild('Previous editions', ['uri' => 'https://imdis.seadatanet.org/Previous-editions']);
        
        $menu[$infoLabel]['Previous editions']->setLinkAttribute('target', '_blank');
        
        
        if ($this->auth->isGranted('ROLE_ADMIN')) {
            $menu->addChild('Registrations', ['route'=>'user_index']);
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
}
