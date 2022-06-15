<?php

namespace App\Controller;

use App\Entity\Capacitor;
use App\Entity\Component;
use App\Entity\Filter;
use App\Entity\Inductor;
use App\Entity\Resistor;
use App\Repository\ComponentRepository;
use App\Service\FilterComponentService;
use App\Visitor\CreateFormVisitor;
use App\Visitor\CustomFieldsVisitor;
use App\Visitor\UnitsVisitor;
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
    public function listComponents(Request $request, ManagerRegistry $registry, string $type): Response
    {
        $types = [
            'resistor' => ['class' => Resistor::class, 'fields' => ['power', 'package']],
            'capacitor' => ['class' => Capacitor::class, 'fields' => ['voltage', 'temperatureCoefficient']],
            'inductor' => ['class' => Inductor::class, 'fields' => ['maxCurrent', 'DCResistance']],
        ];
        $fields = ['name', 'value', 'tolerance', 'price'];
        $repository = $registry->getRepository($types[$type]['class']);
        $components = $repository->findAll();

        if ($request->query->has('sort')) {
            $components = $this->sort($request, $components);
        }

        if ($request->query->has('field')) {
            $components = $this->filter($request, $repository);
        }

        return $this->render('component/index.html.twig', [
            'fields' => array_merge($fields, $types[$type]['fields']),
            'components' => $components,
            'type' => $type,
        ]);
    }

    protected function sort(Request $request, array $components): array
    {
        $field = $request->query->get('sort');
        usort($components,
            ['App\Entity\ComponentComparator', 'compare' . $field]);
        if ($request->query->has('asc')) {
            $components = array_reverse($components, true);
        }
        return $components;
    }

    private function filter(Request $request, $repository): array
    {
        $filter = new Filter();
        $filter->setField($request->query->get('field'));
        $filter->setValue($request->query->get('value'));
        return FilterComponentService::findByField($filter, $repository);
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
        $component->setUser($this->getUser());

        $form = $this->createForm($component->accept(new CreateFormVisitor()), $component);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $componentRepository->add($component, true);
            return $this->redirectToRoute('app_component_base', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('component/new.html.twig', [
            'component' => $component,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_component_show', methods: ['GET'])]
    public function show(Component $component): Response
    {
        return $this->render('component/show.html.twig', [
            'component' => $component,
            'fields' => $component->accept(new CustomFieldsVisitor()),
            'unit' => $component->accept(new UnitsVisitor()),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_component_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Component $component, ComponentRepository $componentRepository): Response
    {
        $form = $this->createForm($component->accept(new CreateFormVisitor()), $component);
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
