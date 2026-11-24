<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/posts')]
final class PostController extends AbstractController
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('', name: 'post_listar', methods: ['GET'])]
    public function listar(Request $request): Response
    {
        $termo = $request->query->getString('q');
        $status = $request->query->getString('status');

        return $this->render('post/listar.html.twig', [
            'posts' => $this->postRepository->buscar($termo, $status),
            'termo' => $termo,
            'status' => $status,
            'total' => $this->postRepository->count([]),
            'totalPublicados' => $this->postRepository->count(['publicado' => true]),
        ]);
    }

    #[Route('/novo', name: 'post_novo', methods: ['GET', 'POST'])]
    public function novo(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($post);
            $this->entityManager->flush();

            $this->addFlash('success', 'Post cadastrado com sucesso!');

            return $this->redirectToRoute('post_exibir', ['id' => $post->getId()]);
        }

        return $this->render('post/novo.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'post_exibir', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function exibir(Post $post): Response
    {
        return $this->render('post/exibir.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/editar', name: 'post_editar', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function editar(Post $post, Request $request): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'Post atualizado com sucesso!');

            return $this->redirectToRoute('post_exibir', ['id' => $post->getId()]);
        }

        return $this->render('post/editar.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/excluir', name: 'post_excluir', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function excluir(Post $post, Request $request): Response
    {
        if ($this->isCsrfTokenValid('excluir-post-' . $post->getId(), $request->getPayload()->getString('_token'))) {
            $this->entityManager->remove($post);
            $this->entityManager->flush();

            $this->addFlash('success', 'Post excluído com sucesso!');
        } else {
            $this->addFlash('error', 'Token inválido. Tente novamente.');
        }

        return $this->redirectToRoute('post_listar', [], Response::HTTP_SEE_OTHER);
    }
}
