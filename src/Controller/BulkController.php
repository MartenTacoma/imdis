<?php
namespace App\Controller;

use App\Entity\Poster;
use App\Entity\Presentation;
use App\Entity\ImdisAbstract;
use App\Entity\AbstractPerson;
use App\Repository\ImdisAbstractRepository;
use App\Repository\ThemeRepository;
use App\Repository\PresentationTypeRepository;
use Doctrine\Persistence\ManagerRegistry;
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
    function index(
        ThemeRepository $themeRepository,
        PresentationTypeRepository $PresentationTypeRepository,
        ManagerRegistry $doctrine
    ) {
        $file = fopen('programma.csv', 'r');
        
        $entityManager = $doctrine->getManager();
        $labels = fgetcsv($file);
        while($line = array_combine($labels, fgetcsv($file))){
            $theme = $themeRepository->findOneByTitle($line['Session']);
            $abstract = new ImdisAbstract();
            $abstract
                ->setTitle($line['Title'])
                ->setAbstract($line['Abstract'])
                ->setImdisId($line['id'])
                ->setTheme($theme)
            ;
            $person = new AbstractPerson();
            $person->setName($line['Presenter'])
                ->setIsPresenter(true)
                ->setSort(1);
            $abstract->addPerson($person);
            if($line['Co']){
                $authors = explode(',', $line['Co']);
                $n = 2;
                foreach ($authors as $author){
                    $person = new AbstractPerson();
                    $person->setName(trim($author))
                        ->setIsPresenter(false)
                        ->setSort($n);
                    $n++;
                    $abstract->addPerson($person);
                }
            }
            
            $entityManager->persist($abstract);
                
            $presentation = new Presentation();
            $presentation->setAbstract($abstract)
                ->setProgramSession($theme->getSession()[0])
                ->setTimeStart(new \DateTime($line['Time']))
                ->setType($PresentationTypeRepository->findOneById(1));
            $entityManager->persist($presentation);
            
            $entityManager->flush();
        }
    }
    
    /**
     * @Route("/poster")
     */
    function poster(
        ThemeRepository $themeRepository,
        ManagerRegistry $doctrine
    ) {
        
        $file = fopen('posters.csv', 'r');
        
        $entityManager = $doctrine->getManager();

        while($line = fgetcsv($file)){
            if(!empty(trim($line[0]))){
                $theme = $themeRepository->findOneById($line[0]);
                $abstract = new ImdisAbstract();
                $abstract
                    ->setTitle($line[3])
                    ->setImdisId($line[1])
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