<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Form\Manufacturer1Type;
use App\Form\ManufacturerType;
use App\Repository\ManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/manufacturer')]
class ManufacturerController extends AbstractController
{
    #[Route('/', name: 'app_manufacturer_index', methods: ['GET'])]
    public function index(ManufacturerRepository $manufacturerRepository): Response
    {
        return $this->render('manufacturer/index.html.twig', [
            'manufacturers' => $manufacturerRepository->findBy(['user' => $this->getUser()]),
        ]);
    }

    #[Route('/new', name: 'app_manufacturer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManufacturerRepository $manufacturerRepository): Response
    {
        $manufacturer = new Manufacturer();
        $manufacturer->setUser($this->getUser());
        $form = $this->createForm(ManufacturerType::class, $manufacturer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manufacturerRepository->add($manufacturer, true);

            return $this->redirectToRoute('app_manufacturer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('manufacturer/new.html.twig', [
            'manufacturer' => $manufacturer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_manufacturer_show', methods: ['GET'])]
    public function show(Manufacturer $manufacturer): Response
    {
        return $this->render('manufacturer/show.html.twig', [
            'manufacturer' => $manufacturer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_manufacturer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Manufacturer $manufacturer, ManufacturerRepository $manufacturerRepository): Response
    {
        $form = $this->createForm(ManufacturerType::class, $manufacturer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manufacturerRepository->add($manufacturer, true);

            return $this->redirectToRoute('app_manufacturer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('manufacturer/edit.html.twig', [
            'manufacturer' => $manufacturer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_manufacturer_delete', methods: ['POST'])]
    public function delete(Request $request, Manufacturer $manufacturer, ManufacturerRepository $manufacturerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $manufacturer->getId(), $request->request->get('_token'))) {
            $manufacturerRepository->remove($manufacturer, true);
        }

        return $this->redirectToRoute('app_manufacturer_index', [], Response::HTTP_SEE_OTHER);
    }
}
