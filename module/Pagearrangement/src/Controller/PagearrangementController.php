<?php

namespace Pagearrangement\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Rubrique\Form\RubriqueForm;
use Rubrique\Form\RubriqueInputFilter as InputFilter;
use Rubrique\Model\RubriqueDao;
use Contenu\Model\ContenuDao;
use Sousrubrique\Model\Sousrubriquedao;
use Linktocontenu\Model\LinktocontenuDao;
use Pagearrangement\Model\PagearrangementDao;
use ExtLib\Utils;
use Zend\Mvc\I18n\Translator;

class PagearrangementController extends AbstractActionController {

    private $translator;

    public function __construct(Translator $translator){
        $this->translator = $translator;
    }

    public function indexAction() {

        $rubriqueDao = new RubriqueDao();
 
        return new ViewModel(array(
            //'rubriques' => $rubriqueDao->fetchAll(),
            'rubriques' => $rubriqueDao->getAllRubriques("object"),
                //'session'=> $useraccess
        ));
    }
    
    public function updatecontentspositionajaxAction(){
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $node = $request->getPost('nodeType');
            $position = (int)$request->getPost('position');
            $id = (int)$request->getPost('id');
            
            $isOk = false;
            
            if(strcmp($node, "linktocontenu")==0){
                $linktocontenuDao = new LinktocontenuDao();
                $isOk = $linktocontenuDao->updateLinktocontenuPosition($id, $position);
            }
            else{
                $contenuDao = new ContenuDao();
                $isOk = $contenuDao->updateContenuPosition($id, $position);
            }
            
            return $this->getResponse()->setContent(json_encode(array('result'=>$isOk)));
            
        }
    }

    public function showpagecontentsAction() {
        
        $pagearrangementDao = new PagearrangementDao();
        $rubriqueDao = new RubriqueDao();
        
        // $this->translator=$this->getServiceLocator()->get('translator');
        
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if(empty($id)){
           return $this->notFoundAction();
        }

        $page = $rubriqueDao->getRubrique($id);
        
        $isEmpty = count($page);
        
        if ($isEmpty <= 0) {
            return $this->notFoundAction();
        }

        $data = $pagearrangementDao->getPage($id, "asc", "json");
        //var_dump($data);
        //exit;
        //return $this->getResponse()->setContent($data);
        return new ViewModel(array(
            'page' => $data
        ));
        
    }

    public function updatesectionspositionajaxAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $position = (int)$request->getPost('position');
            $id = (int)$request->getPost('id');
            
            $isOk = false;
            
             $sousrubriqueDao = new Sousrubriquedao();
             $isOk = $sousrubriqueDao->updatepositionSousrubrique($id, $position);
            
            return $this->getResponse()->setContent(json_encode(array('result'=>$isOk)));
            
        }
        
    }
}
