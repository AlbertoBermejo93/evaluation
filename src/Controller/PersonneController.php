<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use App\Repository\PersonneRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    #[Route('/personne', name: 'app_personne')]
    public function index(): Response
    {
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
        ]);
    }
    #[Route('/personne/liste', name: 'personne_liste')]
    public function listePersonne(PersonneRepository $personneRepository): Response
    {
        $personnes = $personneRepository->findBy(array(), array('nom' => 'ASC'));
      
        return $this->render('personne/listePersonne.html.twig', [
            'controller_name' => 'PersonneController',
            'personnes'=> $personnes,
        ]);
    }
    #[Route('/personne/creer', name: 'personne_creer')]
    #[Route('/personne/voir/{id}', name: 'personne_voir')]
    public function CreerPersonne(int $id = null, ManagerRegistry $doctrine, Request $request, PersonneRepository $personneRepository): Response
    {
        $registryManager = $doctrine->getManager();

        if($id == null){
            $personne = new Personne();
        }else{
            $personne = $personneRepository->findOneById($id);
            if(!$personne){
                throw $this->createNotFoundException('La personne n\'existe pas');
            }
        }
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $personne = $form->getData();


            $registryManager->persist($personne);
            $registryManager->flush();

            $this->addFlash('success', 'Personne enregistrée');
            return $this->redirectToRoute('personne_voir', ['id' => $personne->getId()]);
        }
        return $this->render('personne/afficherPersonne.html.twig', [
            'controller_name' => 'PersonneController',
            'personne' => $personne,
            'form'=>$form->createView(),
        ]);
    }
}
