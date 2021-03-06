<?php

namespace Privatespace\Controller;

use Privatespace\Model\Privatespace;
use Privatespace\Model\PrivatespaceDao;
use Privatespace\Form\PrivatespaceForm;
use Privatespace\Form\PrivatespaceInputFilter as InputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use ExtLib\Utils;
use Zend\Mvc\I18n\Translator;
use Application\Factory\CacheDataListener;

class PrivatespaceController extends AbstractActionController {

    private $cache;
    private $translator;

    public function __construct(CacheDataListener $cache, Translator $translator){
        $this->cache = $cache;
        $this->translator = $translator;
    }

    public function indexAction() {

        $privatespaceDao = new PrivatespaceDao();

        return new ViewModel(array(
            'spaces' => $privatespaceDao->getAllSpaces('object')
        ));
    }

    // Add content to this method:
    public function addAction() {

        $form = new PrivatespaceForm();

        // $this->translator=$this->getServiceLocator()->get('translator');
        $form->get('submit')->setAttribute('value', $this->translator->translate('Ajouter'));

        $privatespaceDao = new PrivatespaceDao();
        $space = new Privatespace();

        $form->bind($space);
        $request = $this->getRequest();

        if ($request->isPost()) {

            //$form->setInputFilter($space->getInputFilter());
            $form->setInputFilter(new InputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $utils = new Utils();
                $request->getPost()->set('name', $utils->stripTags_replaceHtmlChar_trim($request->getPost('name'), true, true, true));

                $privatespaceDao->saveSpace($space);

                //flush cache
                $this->cache->getCacheService()->flush();

                // Redirect to list of privatespaces
                return $this->redirect()->toRoute('privatespace', array('action' => 'index'));
            } else {

                return array(
                    'form' => $form,
                    'error' => $form->getMessages());
            }
        }

        return array(
            'form' => $form,
            'error' => '');
    }

    public function editAction() {

        $privatespaceDao = new PrivatespaceDao();
        // $this->translator=$this->getServiceLocator()->get('translator');

        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('privatespace', array(
                        'action' => 'add'
            ));
        }

        $space = $privatespaceDao->getSpace($id);

        $privatespaceId = $space->getId();
        if(!empty($id)){
            if (empty($privatespaceId)) {
                //return $this->getResponse()->setStatusCode(404);
                return $this->notFoundAction();
            }
        }

        $form = new PrivatespaceForm();
        //form : bind data to automatically build privatespace object
        $form->bind($space);

        $form->get('submit')->setAttribute('value', $this->translator->translate('Modifier'));

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setInputFilter(new InputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $utils = new Utils();
                $request->getPost()->set('libelle', $utils->stripTags_replaceHtmlChar_trim($request->getPost('libelle'), true, true, true));
                //$privatespace = Rubrique::fromArray($form->getData());

                $privatespaceDao->saveSpace($space);

                //flush cache
                $this->cache->getCacheService()->flush();

                // Redirect to list of privatespaces
                return $this->redirect()->toRoute('privatespace');
            } else {

                return array(
                    'id' => $id,
                    'form' => $form,
                    'error' => $form->getMessages());
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
            'error' => ''
        );
    }

    public function deleteAction() {

        $privatespaceDao = new PrivatespaceDao();
        // $this->translator=$this->getServiceLocator()->get('translator');

        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('privatespace');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $del = $request->getPost('del', $this->translator->translate('Non'));

            if ($del == $this->translator->translate('Oui')) {
                $id = (int) $request->getPost('id');

                $privatespaceDao->deleteSpace($id);

                //flush cache
                $this->cache->getCacheService()->flush();
            }

            // Redirect to list of privatespaces
            return $this->redirect()->toRoute('privatespace');
        }

        $privatespace = $privatespaceDao->getSpace($id);

        return array(
            'id' => $id,
            'privatespace' => $privatespace
        );
    }

}
