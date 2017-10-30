<?php

// module/Fichiers/src/Fichiers/Form/FichiersForm.php:

namespace Confmgmt\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use ExtLib\Utils;

//use Zend\Stdlib\Hydrator\ClassMethods;

class ConfmgmtForm extends Form {

    private $utils;

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('confmgmtfichiers');
        $this->utils = new Utils();

        //$this->setHydrator(new ClassMethods);
        $this->setAttribute('method', 'post');
        $this->setAttribute("enctype","multipart/form-data");

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'imagepath',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'fichierpath'
            ),
        ));

        $this->add(array(
            'name' => 'libelle',
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'metadata',
            'attributes' => array(
                'type' => 'text'
            ),
        ));


        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'newfichier',
            'attributes' => array(
                'id' => 'newfichierId',
            //'class'	   => 'sousrubriqueSelectIdClass'
            ),
            'options' => array(
                'label' => $this->utils->translate('Choisir un fichier'),
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => $this->utils->translate('Valider'),
                'id' => 'submitbutton',
            ),
        ));
    }

}
