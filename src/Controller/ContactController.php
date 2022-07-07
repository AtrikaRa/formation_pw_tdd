<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\ContactType;
use App\Entity\ContactData;
use App\Form\Type\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        $data = new ContactData();
        $form = $this->createForm(ContactType::class, $data);
        
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            $validForm = true;

            if(!$contactFormData->getNom()){
                $validForm = false;
                $this->addFlash('invalid', 'Nom invalide');
            }

            if(!$contactFormData->getEmail() || !filter_var($contactFormData->getEmail(), FILTER_VALIDATE_EMAIL)){
                $validForm = false;
                $this->addFlash('invalid', 'Email invalide');
            }

            if(!$contactFormData->getMessage()){
                $validForm = false;
                $this->addFlash('invalid', 'Message invalide');
            }
            
            if($validForm){

                $em->persist($data);
                $em->flush();
                $this->addFlash('success', 'Vore message a été envoyé');
            }

            return $this->redirectToRoute('contact');
        }

        return $this->renderForm('home/index.html.twig', [
            'form' => $form
        ]);
    }
}