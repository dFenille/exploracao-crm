<?php
namespace Application\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class CartasEmailForm extends Form implements InputFilterProviderInterface
{

    public function __construct(){
        parent::__construct('cartas-email');

        $this->add(array('name' => 'carta',
                         'type'=>'text',
                         'attributes' => array(
                             'class'=>'form-control',
                             'placeholder' => 'Carta' ,
                         )
                    ));


        $this->add(array('name' => 'descr',
            'type'=>'textarea',
            'attributes' => array(
                'class'=>'form-control',
                'placeholder' => 'Descricao' ,
                'cols' => 20,
                'rows' => 5,
            )
        ));


        $this->add(array('name' => 'modelo',
            'type'=>'textarea',
            'attributes' => array(
                'class'=>'form-control',
                'placeholder' => 'Descricao' ,
                'cols' => 20,
                'rows' => 10,
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
        return array(
            'csrf' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'Csrf'
                    )
                )
            ),
                    'carta'=> array('required'=>true),
                    'descr'=> array('required'=>true),
                    'modelo'=> array('required'=>true),
            );
    }

}