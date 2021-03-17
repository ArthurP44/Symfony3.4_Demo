<?php


namespace AppBundle\Form;


use AppBundle\Entity\Comment;
use AppBundle\Entity\Product;
use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'label'=> 'Product :',
                'placeholder'=> 'Choose a product',
                'choice_label' => 'name'
            ])
            ->add('comment', TextType::class)
            ->add('submit', SubmitType::class, ['label'=> 'Send']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}