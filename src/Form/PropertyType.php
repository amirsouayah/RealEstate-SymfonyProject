<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title',null, [
                "label" => 'Titre'
            ])
            ->add('Surface', TextType::Class)
            ->add('rooms',null, [
                "label" => 'Chambres'
            ])
            ->add('bedrooms',null, [
                "label" => 'Chambres a coucher'
            ])
            ->add('floor',null, [
                "label" => 'Etages'
            ])
            ->add('price',null, [
                "label" => 'Prix'
            ])
            ->add('heat',ChoiceType::class, [
                "label" => 'Chauffage',
                "choices" => $this->getChoices()
            ])

            ->add('imageFile', FileType::class, [
                'required' => false
            ])
            ->add('city',null, [
                "label" => 'Ville'
            ])
            ->add('adress',null, [
                "label" => 'Adresse'
            ])
            ->add('postal_code',null, [
                "label" => 'Code Postale'
            ])
            ->add('sold',null, [
                "label" => 'Vendu'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }

    private function getChoices()
    {
        $choices = Property::HEAT;
        $output = [];
        foreach($choices as $k => $v ){
            $output[$v] = $k;
        }
        return $output;
    }
}
