<?php

namespace App\Controller;



// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\HttpFoundation\Response;
// use App\Entity\Property;
// use App\Repository\PropertyRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

use Twig\Environment;

class PropertyController  extends AbstractController
{
    
    /**
     * @var PropertyRepository
     */

    private $repository;
    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    
    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */

    public function index(PaginatorInterface $paginator, Request $request): Response 
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
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        //Pagination
        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            8
        );
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }
        //         $search = new PropertySearch();
        //         $form = $this->createForm(PropertySearchType::class,$search);
        //         $form->handleRequest($request);    


        //         $properties = $paginator->paginate(
        //             $this->repository->findAllVisibleQuery($search),
        //             $request->query->getInt('page',1),12
        //         );
                
        //         return $this->render('property/index.html.twig', [
        //             'current_menu' => 'properties',
        //             'properties' => $properties,
        //             'form'       => $form->createView()
        //     ]);
        // }

        /**
        * @Route("/biens/{id}/{slug}", name="property.show")
        * @param Property $property
        * @return Response
        */
        public function show($id, $slug) 
        {
            $repository = $this->getDoctrine()->getRepository(Property::Class);

            
            $property = $repository->find($id);
            return $this->render('property/show.html.twig',[
                'property' => $property,
                'current menu' => 'properties'
            ]);
        }

}