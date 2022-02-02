<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Entity\Produit;
use App\Form\EntreeType;
use App\Repository\EntreeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/entree")
*/
class EntreeController extends AbstractController
{
    /**
    * @Route("/", name="entree_index", methods={"GET"})
    */
    public function index(EntreeRepository $entreeRepository): Response
    {
        return $this->render('entree/index.html.twig', [
            'entrees' => $entreeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="entree_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $entree = new Entree();
        $form = $this->createForm(EntreeType::class, $entree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entree);
            $entityManager->flush();

            //Mise en jour du produit
            $produit = $entityManager->getRepository(Produit::class)->find($entree->getProduit()->getId());
            $stock = $produit->getQteStock() + $entree->getQteEntree();
            $produit->setQteStock($stock);
            $entityManager->flush();

            return $this->redirectToRoute('entree_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entree/new.html.twig', [
            'entree' => $entree,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="entree_show", methods={"GET"})
     */
    public function show(Entree $entree): Response
    {
        return $this->render('entree/show.html.twig', [
            'entree' => $entree,
        ]);
    }
    /**
    *@Route("/{id}/edit", name="entree_edit", methods={"GET","POST"})
    */
    public function edit(Request $request, Entree $entree): Response
    {
        $form = $this->createForm(EntreeType::class, $entree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entree_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entree/edit.html.twig', [
            'entree' => $entree,
            'form' => $form,
        ]);
    }
    /**
    * @Route("/{id}", name="entree_delete", methods={"POST"})
    */
    public function delete(Request $request, Entree $entree): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entree->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entree);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entree_index', [], Response::HTTP_SEE_OTHER);
    }
}
