<?php

namespace Mhhetier\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('auteur', 'text')                
            ->add('contenu')
            ->add('datecreation')
            ->add('publication', 'checkbox', array("required" => false))
            ->add('categories', 'entity',
                  array("class" => "MhhetierBlogBundle:Categorie",
                      "property" => "nom",
                      "multiple" => true,
                      "expanded" => true)) 
            ;        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mhhetier\BlogBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mhhetier_blogbundle_article';
    }
}
