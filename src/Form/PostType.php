<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class, [
                'label' => 'Título',
                'attr' => ['placeholder' => 'Digite o título do post'],
            ])
            ->add('resumo', TextType::class, [
                'label' => 'Resumo',
                'required' => false,
                'attr' => ['placeholder' => 'Uma breve descrição (opcional)'],
            ])
            ->add('categoria', TextType::class, [
                'label' => 'Categoria',
                'required' => false,
                'attr' => ['placeholder' => 'Ex.: Tecnologia, Notícias...'],
            ])
            ->add('autor', EntityType::class, [
                'label' => 'Autor',
                'class' => Usuario::class,
                'choice_label' => 'nome',
                'required' => false,
                'placeholder' => '— Sem autor —',
            ])
            ->add('conteudo', TextareaType::class, [
                'label' => 'Conteúdo',
                'attr' => ['rows' => 10, 'placeholder' => 'Escreva o conteúdo do post...'],
            ])
            ->add('publicado', CheckboxType::class, [
                'label' => 'Publicar agora',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
