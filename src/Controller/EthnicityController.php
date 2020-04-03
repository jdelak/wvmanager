<?php

namespace App\Controller;

use App\Entity\Ethnicity;
use App\Form\EthnicityType;
use App\Repository\EthnicityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ethnicity")
 */
class EthnicityController extends AbstractController
{
    /**
     * @Route("/", name="ethnicity_index", methods={"GET"})
     */
    public function index(EthnicityRepository $ethnicityRepository): Response
    {
        return $this->render('ethnicity/index.html.twig', [
            'ethnicities' => $ethnicityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ethnicity_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ethnicity = new Ethnicity();
        $form = $this->createForm(EthnicityType::class, $ethnicity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ethnicity);
            $entityManager->flush();

            return $this->redirectToRoute('ethnicity_index');
        }

        return $this->render('ethnicity/new.html.twig', [
            'ethnicity' => $ethnicity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ethnicity_show", methods={"GET"})
     */
    public function show(Ethnicity $ethnicity): Response
    {
        return $this->render('ethnicity/show.html.twig', [
            'ethnicity' => $ethnicity,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ethnicity_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ethnicity $ethnicity): Response
    {
        $form = $this->createForm(EthnicityType::class, $ethnicity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ethnicity_index');
        }

        return $this->render('ethnicity/edit.html.twig', [
            'ethnicity' => $ethnicity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ethnicity_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ethnicity $ethnicity): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ethnicity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ethnicity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ethnicity_index');
    }
}
