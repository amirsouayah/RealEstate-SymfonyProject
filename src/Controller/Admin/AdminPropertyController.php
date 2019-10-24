<?php

// namespace App\Controller\Admin;

// use App\Repository\PropertyRepository;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Routing\Annotations\Route;

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Property;
use App\Form\PropertyType;
use Doctrine\Common\Persistence\ObjectManager;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\Request;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;


class AdminPropertyController extends AbstractController

{
    /**
     * @var PropertyRepository
     */
    private $repository;
    private $em;
    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     * @param Property $property 
     * @return Response
     */

    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig',compact('properties'));
    }

    /**
     * @Route ("/admin/property/create", name="admin.property.new")
     * @param Property $property 
     * @return Response
     */
    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Création validée');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit" ,methods="GET|POST")
     * @param Property $property
     * @param Request $request
     * @return Response
     */

    public function edit(Property $property,Request $request, CacheManager $cacheManager,UploaderHelper $helper)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($property->getImageFile() instanceof UploadedFile){
                $cacheManager->remove($helper->asset($property,'imageFile'));//supprimer le Cache 
            }
            $this->em->flush();
            $this->addFlash('success','Bien modifié avec succés');
            return $this->redirectToRoute('admin.property.index');
                          
        }
        
        return $this->render("admin/property/edit.html.twig",[
            'property' => $property,
            'form' => $form->createView()
        ]);
        
    }

    /**
     * @Route ("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property 
     * @return Symfony\Component\HttpFoundation\RedirectResponse;
     */


    public function delete(Property $property, Request $request)
    {
        
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
           
            
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Suppression validée');
          
        }
        
        return $this->redirectToRoute('admin.property.index');
    }


}