<?php

namespace App\Controller;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Entity\Appointment;
use App\Form\AppointmentType;
use App\Form\SearchPropertyType;
use Symfony\Component\Mime\Email;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
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

        $form = $this->createForm(PropertyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $property = new Property();
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
    public function all(PropertyRepository $propertyRepository, Request $request, PaginatorInterface $paginator): Response
    {

        $form = $this->createForm(SearchPropertyType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();
            $title = "Voici les résultats de votre recherche"; 
            $properties = $propertyRepository->findBySearch($search['roomsMin'], $search['roomsMax'], $search['surfaceMin'], $search['surfaceMax'], $search['priceMin'], $search['priceMax']);
        } else {
            $title = "Vous pouvez faire une recherche en utilisant le formulaire. Autrement, voici l'ensemble de nos biens disponibles"; 
            $properties = $propertyRepository->findFilterProperties($request->query->all());
            $bob = 1;
        }

        $pagination = $paginator->paginate(
            $properties,
            $request->query->getInt('page', 1),
            9
        );

        return $this->renderForm('property/all.html.twig', [
            'form' => $form,
            'pagination' => $pagination,
            'filters' => $request->query->all()
        ]);
    }

    #[Route('/bien/{slug}', name: 'property_show', methods: ['GET', 'POST'])]
    public function show(Property $property, Request $request, MailerInterface $mailer): Response
    {
        $appointment = new Appointment;
        $appointment->setProperty($property);
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);
        $formData = null;
        $message = null;

        if($form->isSubmitted() && $form->isValid())
        {
            $formData = $form->getData();

        if($formData->getDateOf()){
            if(in_array(date_format($formData->getDateOf(), "N"),[1,2,3,4,5])) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($appointment);
                $entityManager->flush();

                $emailEmployee = (new Email())
                ->from($formData->getProperty()->getEmployee()->getEmail())
                ->to($formData->getProperty()->getEmployee()->getEmail())
                ->subject('Notre rendez-vous en ligne')
                ->text("Le rendez-vous ")
                ->html('<p>See Twig integration for better HTML integration!</p>');
    
                $emailCustomer= (new Email())
                ->from($formData->getProperty()->getEmployee()->getEmail())
                ->to($formData->getMailCustomer())
                ->subject("Votre prise de rendez-vous -  ")
                ->text("Le rendez-vous du {$formData->getDateOf()->format("d-l-Y H:i:s")} a bien été enregistré et c'est {$formData->getProperty()->getEmployee()->getFirstname()} {$formData->getProperty()->getEmployee()->getLastname()} qui vous fera visiter ce bien ")
                ->html('<p>See Twig integration for better HTML integration!</p>');
    
    
            $mailer->send($emailEmployee);
            $mailer->send($emailCustomer);
            } else {        $this->addFlash("notice","La plage horaire du rendez-vous n'est pas valide, merci de vérifier que vous prenez rendez-vous sur les horaires d'ouverture de l'agence.");
            }}
        
        }

        return $this->render('property/show.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
            'appointment' => $appointment,
            'data' =>$formData,
            'message' => $message
        ]);
    }

    #[Route('/edit/{id}', name: 'property_edit', methods: ['GET', 'POST'])]
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

    #[Route('/property/{id}', name: 'property_delete', methods: ['POST'])]
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
