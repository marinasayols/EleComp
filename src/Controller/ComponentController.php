<?php

namespace App\Controller;

use App\Entity\Capacitor;
use App\Entity\Component;
use App\Entity\Inductor;
use App\Entity\Resistor;
use App\Repository\ComponentRepository;
use App\Visitor\CreateComponentVisitor;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/component')]
class ComponentController extends AbstractController
{
    #[Route('/', name: 'app_component_base', methods: ['GET'])]
    public function initial(): Response
    {
        return $this->render('component/base.html.twig');
    }

    #[Route('/{type}', name: 'app_component_index', methods: ['GET'])]
    public function listComponents(ManagerRegistry $registry, string $type): Response
    {
        $types = [
            'resistor' => Resistor::class,
            'capacitor' => Capacitor::class,
            'inductor' => Inductor::class
        ];
        $components = $registry->getRepository($types[$type])->findAll();
        $fields = ['name', 'value', 'tolerance', 'price'];
        $types_fields = [
            'resistor' => ['power', 'package'],
            'capacitor' => ['voltage', 'temperatureCoefficient'],
            'inductor' => ['maxCurrent', 'DCResistance'],
        ];
        return $this->render('component/index.html.twig', [
            'fields' => ($type === null) ? $fields : array_merge($fields, $types_fields[$type]),
            'components' => $components,
            'type' => $type,
        ]);
    }

    #[Route('/new/{type}', name: 'app_component_new', methods: ['GET', 'POST'])]
    public function new(Request $request, string $type, ComponentRepository $componentRepository): Response
    {
        $types = [
            'resistor' => new Resistor(),
            'capacitor' => new Capacitor(),
            'inductor' => new Inductor(),
        ];
        $component = $types[$type];

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

    #[Route('/details/{id}', name: 'app_component_show', methods: ['GET'])]
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

            return $this->redirectToRoute('app_component_base', [], Response::HTTP_SEE_OTHER);
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

        return $this->redirectToRoute('app_component_base', [], Response::HTTP_SEE_OTHER);
    }
}
