<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConctactController extends AbstractController
{
   private $manager;
    public function __construct(ManagerRegistry $doctrine)
    {
      $this->manager=$doctrine->getManager();
    }
    #[Route('/contact', name: 'app_contact')]
     public function index(Request $request, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $contact->setDateMessage(new DateTime('today'));
        if($this->getUser()){
            $contact->setNom($this->getUser()->getNom())
                    ->setPrenom($this->getUser()->getPrenom())
                    ->setEmail($this->getUser()->getEmail());
            }
    $form=$this->createForm(ContactType::class, $contact);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
        $contact=$form->getData();
        $this->manager->persist($contact);
        $this->manager->flush();

        // methode pour envoyer un mail
        $email=(new TemplatedEmail())
        ->from($contact->getEmail())
        ->to('contact@modeTry.com')
        ->subject($contact->getSujet())
        ->htmlTemplate('emails/contact.html.twig')
        ->context([
            'contact'=>$contact
        ]);
        $mailer->send($email);
        $this->addFlash('success','message envoyé');
        return $this->redirectToRoute('app_contact');
        
    }


        return $this->render('conctact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
