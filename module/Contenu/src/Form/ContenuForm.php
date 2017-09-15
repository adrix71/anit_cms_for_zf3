<?php

// module/SousRubrique/src/SousRubrique/Form/SousRubriqueForm.php:

namespace Contenu\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Rubrique\Model\RubriqueDao;
use ExtLib\Utils;

//use Zend\Stdlib\Hydrator\ClassMethods;

class ContenuForm extends Form {

    protected $utils;

    
    protected function getRubriques() {

        $rubriquesDao = new RubriqueDao();

        $rubriques = $rubriquesDao->getAllRubriques("array");

        $rubriqueArray = array();

        foreach ($rubriques as $value) {

            $rubriqueArray[$value['id']] = $value['libelle'];
        }

        return $rubriqueArray;
    }

    /*
      protected function getSousRubriques($rubid){

      $sousrubriquesDao=  new SousRubriqueDao();

      $sousrubriques = $sousrubriquesDao->getSousrubriquesByRubrique($rubid,"array");

      $sousrubriqueArray = array();

      foreach($sousrubriques as $value){

      $sousrubriqueArray[$value['id']]=$value['libelle'];

      }

      return $sousrubriqueArray;
      }
     */
    /* TODO : get All Sous Rubriques by Id pour le select */

    public function __construct($name = null) {
        
        $this->utils = new Utils(); 

        // we want to ignore the name passed
        parent::__construct('contenuform');
        //$this->setHydrator(new ClassMethods);
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
                'value' => 0
            ),
        ));
        /*
        $this->add(array(
            'name' => 'sousrubriques_id',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'idsousrub'
            ),
        ));
        
          $this->add(array(
          'name' => 'imagepath',
          'attributes' => array(
          'type' => 'hidden',
          'id' => 'imagepath'
          ),
          ));
        
        $this->add(array(
            'name' => 'rubriques_id',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'idrub'
            ),
        ));
        */
        $this->add(array(
            'name' => 'titre',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Titre'),
            ),
        ));

        $this->add(array(
            'name' => 'soustitre',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Sous-Titre'),
            ),
        ));
        
        $this->add(array(
            'name' => 'position',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Position'),
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'sousrubriquesList',
            'attributes' => array(
                'id' => 'sousrubriqueSelectIdTag',
                'class' => 'sousrubriqueSelectIdClass'
            ),
            'options' => array(
                //'label' => 'Choisir la rubrique',
                'empty_option' => $this->utils->translate('Sélectionner une sous-rubrique'),
                'disable_inarray_validator' => true
            //'class' => 'input-medium',
            //'value_options' => $this->getSousRubriques()
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'rubriquesList',
            'attributes' => array(
                'id' => 'rubriqueSelectIdTag',
                'class' => 'rubriqueSelectIdClass'
            ),
            'options' => array(
                //'label' => 'Choisir la rubrique',
                'empty_option' => $this->utils->translate('Sélectionner une rubrique'),
                //'class' => 'input-medium',
                'value_options' => $this->getRubriques()
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'contenu',
            'attributes' => array(
                'id' => 'contenuId',
                'class' => 'contenuClass'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Button',
            'name' => 'submitbutton',
            'options' => array(
                'label' => $this->utils->translate('Valider'),
            ),
            'attributes' => array(
                'value' => $this->utils->translate('Valider'),
                'id' => 'submitbutton',
            ),
        ));
       
    }

}
