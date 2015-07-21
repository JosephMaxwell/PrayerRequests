<?php

namespace JesseMaxwell\PrayerBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PrayerRequestType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'JesseMaxwell\PrayerBundle\Model\PrayerRequest',
        'csrf_protection' => false,
        'name' => 'prayerrequest',
    );

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return $this->options['name'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('description');
        $builder->add('date', 'date', array(
            'widget' => 'single_text'
        ));
        $builder->add('answered');
    }
}
