<?php

namespace App\Controller;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Form\SearchPropertyType;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PropertyController extends AbstractController
{
    #[Route('/', name: 'property_index', methods: ['GET'])]
    public function index(PropertyRepository $propertyRepository): Response
    {
    
        return $this->render('property/index.html.twig', [
            'properties' => $propertyRepository->findBy([],["id" => "DESC"], 5)
        ]);
    }

    #[Route('/type/{propertyType}', name: 'property_type', methods: ['GET', 'POST'])]
    public function type(PropertyRepository $propertyRepository, $propertyType): Response
    {
        
        return $this->render('property/index.html.twig', [
            'properties' => $propertyRepository->findBy(["type" => $propertyType],["id" => "DESC"])
        ]);
    }
    
    #[Route('/transaction/{transactionType}', name: 'property_transactionType', methods: ['GET', 'POST'])]
    public function transaction(PropertyRepository $propertyRepository, $transactionType): Response
            {
            
                return $this->render('property/index.html.twig', [
                    'properties' => $propertyRepository->findBy(["transactionType" => $transactionType],["id" => "DESC"])
                ]);
            }

    #[Route('/new', name: 'property_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($property);
            $entityManager->flush();

            return $this->redirectToRoute('property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('property/new.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    #[Route('/biens', name: 'property_all', methods: ['GET', 'POST'])]
    public function all(PropertyRepository $propertyRepository, Request $request): Response
    {
        $form = $this->createForm(SearchPropertyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();
            $title = "Voici les résultats de votre recherche"; 
            $properties = $propertyRepository->findBySearch($search->roomsMin, $search->roomsMax, $search->surfaceMin, $search->surfaceMax, $search->priceMin, $search->priceMax);

        } else {
            $title = "Vous pouvez faire une recherche en utilisant le formulaire. Autrement, voici l'ensemble de nos biens disponibles"; 
            $properties = $propertyRepository->findAll();
        }

        return $this->renderForm('property/all.html.twig', [
            'form' => $form,
            'properties' => $properties
        ]);
    }

    #[Route('bien/{slug}', name: 'property_show', methods: ['GET'])]
    public function show(Property $property): Response
    {
        return $this->render('property/show.html.twig', [
            'property' => $property,
        ]);
    }

    #[Route('/{id}/edit', name: 'property_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Property $property): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('property/edit.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'property_delete', methods: ['POST'])]
    public function delete(Request $request, Property $property): Response
    {
        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($property);
            $entityManager->flush();
        }

        return $this->redirectToRoute('property_index', [], Response::HTTP_SEE_OTHER);
    }


}
