<?php

namespace AppBundle\Form;

use AppBundle\Entity\Application;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sensors = $options['sensors'];
        $builder->add('sensor', EntityType::class, [
            'class' => 'AppBundle\Entity\Sensor',
            'label' => 'Sensor',
            'choices' => $sensors,
            'choice_label' => 'name',
            'required' =>true,
        ])->add('location', TextType::class, [
            'label' => 'Location',
            'required' => true,
        ])->add('code', VichFileType::class, [
            'label' => false,
            'required' => true,
            'allow_delete' => true,
            'download_link' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'    	=> Application::class,
        ])->setRequired('sensors');
    }

    public function getName()
    {
        return 'app_bundle_application_type';
    }
}
