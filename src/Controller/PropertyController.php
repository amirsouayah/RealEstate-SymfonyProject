<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Twig\Environment;

class PropertyController  extends AbstractController
{
    
    /**
     * @var PropertyRepository
     */


    private $repository;

    /**
     * @var ObjectManager
     */

    // private $em;

    // public function __construct (PropertyRepository $repository, ObjectManager $em)
    // {
    //     $this->repository = $repository;
    //     $this->em = $em;
    // }

    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */

    public function index(): Response 
    {

        // $property = new Property();
        // $property->setTitle('The First One')
        //     ->setPrice(2000000)
        //     ->setRooms(4)
        //     ->setBedrooms(3)
        //     // ->setDescription('a Small Description')
        //     ->setSurface(60)
        //     ->setFloor(4)
        //     ->setHeat(1)
        //     ->setCity('Montpellier')
        //     ->setAdress('15 Boulvard')
        //     ->setPostalCode('34000');
        // $en = $this->getDoctrine()->getManager();
        // $en->persist($property);
        // $en->flush();

        // return $this->render('property/index.html.twig',[
        //       'current menu' => 'properties'
        //       ]);

        // $property = $this->repository->findAllVisible();
                                        //find(1)
                                        //findAll(1)
        // dump($property);
        // $property[0]->setSold(true);                                
        // $repository = $this->getDoctrine()->getRepository(Property::class);
        // dump($repository);
        
        // $this->en->flush();
            
        // $property = $this->repository->findAllVisible();
            return $this->render('property/index.html.twig',[
                'current menu' => 'properties'
            ]);
        }

        /**
        * @Route("/biens/{slug}-{id}", name="property.show")
        * @return Response
        */
        public function show($slug, $id): Reponse
        {
            $property = $this->repository->find($id);
            return $this->render('property/show.html.twig',[
                'property' => $property,
                'current menu' => 'properties'
            ]);
        }

}