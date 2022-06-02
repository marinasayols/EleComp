<?php

namespace App\Controller;

use App\Entity\Capacitor;
use App\Entity\Component;
use App\Entity\Resistor;
use App\Repository\ComponentRepository;
use App\Visitor\CreateComponentVisitor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/component')]
class ComponentController extends AbstractController
{
    #[Route('/', name: 'app_component_index', methods: ['GET'])]
    public function index(ComponentRepository $componentRepository): Response
    {
        return $this->render('component/index.html.twig', [
            'components' => $componentRepository->findAll(),
        ]);
    }

    #[Route('/new/capacitor', name: 'app_component_new_capacitor', methods: ['GET', 'POST'])]
    public function newCapacitor(Request $request, ComponentRepository $componentRepository): Response
    {
        $component = new Capacitor();
        return $this->create($request, $component, $componentRepository);
    }

    public function create(Request $request, Component $component, ComponentRepository $componentRepository): Response
    {
        $form = $this->createForm($component->accept(new CreateComponentVisitor()), $component);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $componentRepository->add($component, true);

            return $this->redirectToRoute('app_component_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('component/new.html.twig', [
            'component' => $component,
            'form' => $form,
        ]);
    }

    #[Route('/new/resistor', name: 'app_component_new_resistor', methods: ['GET', 'POST'])]
    public function newResistor(Request $request, ComponentRepository $componentRepository): Response
    {
        $component = new Resistor();
        return $this->create($request, $component, $componentRepository);
    }

    #[Route('/{id}', name: 'app_component_show', methods: ['GET'])]
    public function show(Component $component): Response
    {
        return $this->render('component/show.html.twig', [
            'component' => $component,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_component_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Component $component, ComponentRepository $componentRepository): Response
    {
        $form = $this->createForm($component->accept(new CreateComponentVisitor()), $component);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $componentRepository->add($component, true);

            return $this->redirectToRoute('app_component_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('component/edit.html.twig', [
            'component' => $component,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_component_delete', methods: ['POST'])]
    public function delete(Request $request, Component $component, ComponentRepository $componentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $component->getId(), $request->request->get('_token'))) {
            $componentRepository->remove($component, true);
        }

        return $this->redirectToRoute('app_component_index', [], Response::HTTP_SEE_OTHER);
    }
}
