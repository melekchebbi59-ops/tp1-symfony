<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class CategorieController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('/categories/nouvelle', name: 'app_categorie_nouvelle')]
    public function nouvelle(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $categorie = new Categorie();

        $form = $this->createFormBuilder($categorie)
            ->add('nom', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('enregistrer', SubmitType::class, [
                'label' => 'Créer la catégorie',
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();

            $this->addFlash('success', 'La catégorie a été créée avec succès.');

            return $this->redirectToRoute('app_categories');
        }

        return $this->render('categorie/nouvelle.html.twig', [
            'form' => $form,
        ]);
    }
}

