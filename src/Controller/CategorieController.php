<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategorieController extends AbstractController
{
    // Liste des catégories
    #[Route('/categories', name: 'app_categories')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    // Création d'une catégorie
    #[Route('/categories/nouvelle', name: 'app_categorie_nouvelle')]
    public function nouvelle(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);

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

    // Afficher une catégorie et ses articles
    #[Route('/categories/{id}', name: 'app_categorie_show', requirements: ['id' => '\d+'])]
    public function show(Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
            'articles' => $categorie->getArticles(),
        ]);
    }

    // Modifier une catégorie
    #[Route('/categories/{id}/modifier', name: 'app_categorie_modifier', requirements: ['id' => '\d+'])]
    public function modifier(
        Categorie $categorie,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'La catégorie a été modifiée avec succès.');

            return $this->redirectToRoute('app_categorie_show', [
                'id' => $categorie->getId(),
            ]);
        }

        return $this->render('categorie/modifier.html.twig', [
            'form' => $form,
            'categorie' => $categorie,
        ]);
    }

    // Supprimer une catégorie
    #[Route('/categories/{id}/supprimer', name: 'app_categorie_supprimer', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function supprimer(
        Categorie $categorie,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if ($categorie->getArticles()->count() > 0) {
            $this->addFlash(
                'danger',
                'Impossible de supprimer cette catégorie car elle contient encore des articles.'
            );

            return $this->redirectToRoute('app_categorie_show', [
                'id' => $categorie->getId(),
            ]);
        }

        if ($this->isCsrfTokenValid(
            'delete' . $categorie->getId(),
            $request->request->get('_token')
        )) {
            $entityManager->remove($categorie);
            $entityManager->flush();

            $this->addFlash('success', 'La catégorie a été supprimée avec succès.');
        }

        return $this->redirectToRoute('app_categories');
    }
}
