<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;


class ArticleType extends AbstractType
{
    private $em;

    /**
     * 
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle');

        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    protected function addElements(FormInterface $form, Category $category = null)
    {
        $form->add('category', EntityType::class, array(
            'label' => 'Catégorie',
            'required' => true,
            'data' => $category,
            'placeholder' => 'Choisir une catégorie',
            'class' => 'App:Category'
        ));
    }

    function onPreSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        // Search for selected category and convert it into an Entity
        $category = $this->em->getRepository('App:Category')->find($data['category']);

        $this->addElements($form, $category);
    }

    function onPreSetData(FormEvent $event)
    {
        $article = $event->getData();
        $form = $event->getForm();

        // When you create a new article, the category is always empty
        $category = $article->getCategory() ? $article->getCategory() : null;

        $this->addElements($form, $category);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
