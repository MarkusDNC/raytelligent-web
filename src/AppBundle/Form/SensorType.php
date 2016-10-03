<?php

namespace AppBundle\Form;

use AppBundle\Entity\Sensor;;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SensorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', TextType::class, [
            'label' => 'Sensor ID',
            'required' => true,
        ])->add('name', TextType::class, [
                'label' => 'Name',
                'required' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'    	=> Sensor::class,
        ]);
    }

    public function getName()
    {
        return 'app_bundle_sensor_type';
    }
}
