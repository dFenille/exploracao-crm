<?php
/**
 * Created by PhpStorm.
 * User: diego.santos
 * Date: 05/09/2016
 * Time: 19:14
 */

namespace Application\Form;


use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class GlossaryForm extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('glossary');

        $this->add(array('name'=>'verbete',
                         'type' => 'text',
                         'attributes' => array(
                            'class' => 'form-control'
                         )
                    ));

        $this->add(array('name'=>'glossario',
            'type' => 'textarea',
            'attributes' => array(
                'class' => 'form-control',
                'rows' => 15,
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Gravar',
                'class' => 'btn btn-primary'
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 600
                )
            )
        ));
    }


    public function getInputFilterSpecification()
    {
        return array('verbete'=>array('required'=>true),
                     'glossario' => array('required'=>true)
                );
    }
}