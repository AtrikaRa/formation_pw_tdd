<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\ContactData;
use App\Form\ContactType;
use App\Form\Type\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request)
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

                $this->addFlash('success', 'Vore message a été envoyé');
            }

            return $this->redirectToRoute('contact');
        }

        return $this->renderForm('home/index.html.twig', [
            'form' => $form
        ]);
    }
}