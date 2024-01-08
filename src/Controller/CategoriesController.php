<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    private $manager;
    public function __construct(ManagerRegistry $doctrine)
    {
     $this->manager = $doctrine->getManager();   
    }
    #[Route('/categories', name: 'app_categories')]
    public function index(Request $request): Response
    {
        $categories = new Categories;
        $form = $this->createForm(CategoriesType::class, $categories,[
            'method' =>'GET'
        ]);
$form->handleRequest($request);
if($form->isSubmitted() && $form->isValid())
{
    $this->manager->persist($categories);
    $this->manager->flush();
    return $this->redirectToRoute('app_categories');
}
        return $this->render('categories/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
