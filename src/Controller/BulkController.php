<?php
namespace App\Controller;

use App\Entity\Poster;
use App\Entity\Presentation;
use App\Entity\ImdisAbstract;
use App\Entity\AbstractPerson;
use App\Repository\ImdisAbstractRepository;
use App\Repository\ThemeRepository;
use App\Repository\PresentationTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/bulk")
 */
class BulkController extends AbstractController
{
    /**
     * @Route("/oral")
     */
    function index(ThemeRepository $themeRepository, PresentationTypeRepository $PresentationTypeRepository) {
        
        $file = fopen('programma.csv', 'r');
        
        $entityManager = $this->getDoctrine()->getManager();

        while($line = fgetcsv($file)){
            if(preg_match('/^[0-9]{1}-[0-9]{2}/', $line[5])){
                $theme = $themeRepository->findOneById(substr($line[5],0,1));
                $abstract = new ImdisAbstract();
                $abstract
                    ->setTitle($line[3])
                    ->setImdisId($line['5'])
                    ->setTheme($theme)
                ;
                $authors = explode(',', str_replace([' and ', ', '], ',', $line['4']));
                $n = 1;
                foreach ($authors as $author){
                    $person = new AbstractPerson();
                    $person->setName(trim($author))
                        ->setIsPresenter($n == 1)
                        ->setSort($n);
                    $n++;
                    $abstract->addPerson($person);
                }
                $entityManager->persist($abstract);
                
                $presentation = new Presentation();
                $presentation->setAbstract($abstract)
                    ->setProgramSession($theme->getSession()[0])
                    ->setTimeStart(new \DateTime(substr($line[1], 0, 5)))
                    ->setType($PresentationTypeRepository->findOneById(strpos($line[2], 'Keynote') !== false ? 2 : 1));
                $entityManager->persist($presentation);
                
                $entityManager->flush();
            }
        }
    }
    
    /**
     * @Route("/poster")
     */
    function poster(ThemeRepository $themeRepository) {
        
        $file = fopen('posters.csv', 'r');
        
        $entityManager = $this->getDoctrine()->getManager();

        while($line = fgetcsv($file)){
            if(!empty(trim($line[0]))){
                $theme = $themeRepository->findOneById($line[0]);
                $abstract = new ImdisAbstract();
                $abstract
                    ->setTitle($line[3])
                    ->setImdisId($line['0'].'-'.$line[1])
                    ->setTheme($theme)
                ;
                $authors = explode(',', str_replace([' and ', ', '], ',', $line['2']));
                $n = 1;
                foreach ($authors as $author){
                    $person = new AbstractPerson();
                    $person->setName(trim($author))
                        ->setIsPresenter($n == 1)
                        ->setSort($n);
                    $n++;
                    $abstract->addPerson($person);
                }
                $entityManager->persist($abstract);
                
                $poster = new Poster();
                $poster->setAbstract($abstract)
                    ->setPosterSession($theme->getPosterSessions()[0]);
                $entityManager->persist($poster);
                
                $entityManager->flush();
            }
        }
    }
}