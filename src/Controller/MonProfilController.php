<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonProfilController extends AbstractController
{

private $manager;
 public function __construct(ManagerRegistry $doctrine)
 {
 $this->manager = $doctrine->getManager();   
 }  



    #[Route('/mon/profil', name: 'app_mon_profil')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('mon_profil/index.html.twig', [
            'controller_name' => 'MonProfilController',
        ]);
    }
    #[Route('/mon-profil/{id}', name:'app_modification_profil')]
public function modificationProfil(Request $request,User $user): Response
{ 
    $this->denyAccessUnlessGranted('ROLE_USER');
    $form = $this->createForm(UserType::class,$user);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
    $this->manager->persist($user);
    $this->manager->flush();
    return $this->redirectToRoute('app_mon_profil');
    }
    return $this->render('mon_profil/profilModification.html.twig',[
        'form' => $form->createView(),
    ]);
 }
}
