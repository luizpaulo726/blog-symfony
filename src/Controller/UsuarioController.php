<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UsuarioController extends AbstractController
{
    private UsuarioRepository $usuarioRep;
    public function __construct(private UsuarioRepository $usuarioRepository) {
        $this->usuarioRep = $usuarioRepository;
    }

    #[Route('/usuario', name: 'usuario_index')]
    public function index(): Response
    {

        $usuarios = $this->usuarioRep->findAll();
        return $this->render('usuario/index.html.twig', [
            'controller_name' => 'UsuarioController',
            'usuarios' => $usuarios
        ]);
    }

    #[Route('/usuarios/novo', name: 'usuario_new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {

        $usuario = new Usuario();

        $form = $this->createForm(UsuarioType::class, $usuario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($usuario);
            $entityManager->flush();

            return $this->redirectToRoute('usuario_index');
        }

        return $this->render('usuario/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/usuarios/{id}/editar', name: 'usuario_edit')]
    public function edit(
        Usuario $usuario,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {

        $form = $this->createForm(UsuarioType::class, $usuario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            return $this->redirectToRoute('usuario_index');
        }

        return $this->render('usuario/edit.html.twig', [
            'form' => $form->createView(),
            'usuario' => $usuario
        ]);
    }


}
