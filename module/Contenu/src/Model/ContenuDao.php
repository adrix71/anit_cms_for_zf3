<?php

namespace Contenu\Model;

use Sousrubrique\Model\Sousrubriquedao;
use Application\DBConnection\ParentDao;
use Contenu\Model\Contenu;
use Contenu\Model\ContenuType;
use Blogcontent\Model\Blogcontent;

class ContenuDao extends ParentDao {

    public function __construct() {
        parent::__construct();
    }

    public function getAllContenus($dataType) {

        $count = 0;
        $sousrubriqueDao = new Sousrubriquedao();

        $requete = $this->dbGateway->prepare("
		SELECT *
		FROM contenu c
                WHERE c.type ='" . ContenuType::$htmlcontent . "'
		ORDER BY c.sousrubriques_id, c.rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if ($dataType == "object") {
            //Put result in an array of objects
            $arrayOfContenustep1 = array();
            $arrayOfContenustep2 = array();

            if (is_array($requete2)) {
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['sousrubriques_id'] != null && $value['sousrubriques_id'] != "") {

                        $sousrubrique = $sousrubriqueDao->getSousrubrique($value['sousrubriques_id']);

                        $arrayOfContenustep1[$count]['id'] = $value['contenu_id'];
                        $arrayOfContenustep1[$count]['titre'] = $value['titre'];
                        $arrayOfContenustep1[$count]['soustitre'] = $value['soustitre'];
                        $arrayOfContenustep1[$count]['contenu'] = $value['contenuhtml'];
                        $arrayOfContenustep1[$count]['position'] = $value['rang'];
                        $arrayOfContenustep1[$count]['image'] = $value['image'];
                        $arrayOfContenustep1[$count]['image2'] = $value['image2'];
                        $arrayOfContenustep1[$count]['sousrubrique'] = $sousrubrique;

                        if (strcasecmp($value['type'], ContenuType::$htmlcontent) == 0 or strcasecmp($value['type'], ContenuType::$galleryItem) == 0) {
                            $arrayOfContenustep2[$count] = Contenu::fromArray($arrayOfContenustep1[$count]);
                        } elseif (strcasecmp($value['type'], ContenuType::$blog) == 0) {
                            $arrayOfContenustep1[$count]['author'] = $value['author'];
                            $arrayOfContenustep1[$count]['themes'] = $value['themes'];
                            $arrayOfContenustep1[$count]['blogdate'] = $value['contenu_date'];
                            $arrayOfContenustep1[$count]['text1'] = $value['othertext1'];
                            $arrayOfContenustep1[$count]['text2'] = $value['othertext2'];
                            $arrayOfContenustep1[$count]['text3'] = $value['othertext3'];

                            $arrayOfContenustep2[$count] = Blogcontent::fromArray($arrayOfContenustep1[$count]);
                        }

                        $count++;
                    }
                }
            }

            return $arrayOfContenustep2;
        } elseif ($dataType == "array") {
            return $requete2;
        }
    }

    public function getAllContenusByRubriqueAndByContenuType($id, $contenuType, $dataType) {

        //var_dump($id);
        $count = 0;
        $count2 = -1;
        $sousrubriqueDao = new Sousrubriquedao();

        $requete = $this->dbGateway->prepare("
		SELECT c.*
		FROM contenu c
                JOIN sousrubrique sr on sr.id = c.sousrubriques_id
                JOIN rubrique r on r.id = sr.rubriques_id
                WHERE r.id = :idrub AND c.rang > -1 AND sr.rang > -1 AND c.type= :contenutype
		ORDER BY sr.rang, c.rang
		")or die(print_r($this->dbGateway->error_info()));
        //WHERE r.id = :idrub AND c.rang > -1 AND sr.rang > -1
        //WHERE r.id = :idrub AND c.rang > -1 AND sr.rang > -1 AND c.type = '".ContenuType::$htmlcontent."'
        $requete->execute(array(
            'idrub' => $id,
            'contenutype' => $contenuType));

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if ($dataType == "object") {
            //Put result in an array of objects
            $arrayOfContenustep1 = array();
            $arrayOfContenustep2 = array();
            $arrayOfContenustep3 = array();

            $sousrub = "";
            if (is_array($requete2)) {
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['sousrubriques_id'] != null && $value['sousrubriques_id'] != "") {

                        //$sousrubrique = $sousrubriqueDao->getSousrubrique($value['sousrubriques_id']);
                        if ($sousrub != $value['sousrubriques_id']) {
                            $count2++;
                            $count = 0;
                        }

                        $sousrub = $value['sousrubriques_id'];

                        $arrayOfContenustep1[$count]['id'] = $value['contenu_id'];
                        $arrayOfContenustep1[$count]['titre'] = $value['titre'];
                        $arrayOfContenustep1[$count]['soustitre'] = $value['soustitre'];
                        $arrayOfContenustep1[$count]['contenu'] = $value['contenuhtml'];
                        $arrayOfContenustep1[$count]['position'] = $value['rang'];
                        $arrayOfContenustep1[$count]['image'] = $value['image'];
                        $arrayOfContenustep1[$count]['image2'] = $value['image2'];
                        //$arrayOfContenustep1[$count]['sousrubrique'] = $sousrubrique;

                        if (strcasecmp($value['type'], ContenuType::$htmlcontent) == 0 or strcasecmp($value['type'], ContenuType::$galleryItem) == 0) {
                            $arrayOfContenustep2[$count] = Contenu::fromArray($arrayOfContenustep1[$count]);
                        } elseif (strcasecmp($value['type'], ContenuType::$blog) == 0) {
                            $arrayOfContenustep1[$count]['author'] = $value['author'];
                            $arrayOfContenustep1[$count]['themes'] = $value['themes'];
                            $arrayOfContenustep1[$count]['blogdate'] = $value['contenu_date'];
                            $arrayOfContenustep1[$count]['text1'] = $value['othertext1'];
                            $arrayOfContenustep1[$count]['text2'] = $value['othertext2'];
                            $arrayOfContenustep1[$count]['text3'] = $value['othertext3'];

                            $arrayOfContenustep2[$count] = Blogcontent::fromArray($arrayOfContenustep1[$count]);
                        }
                        $arrayOfContenustep3[$count2][$count] = $arrayOfContenustep2[$count];

                        $count++;
                    }
                }
            }

            return $arrayOfContenustep3;
        } elseif ($dataType == "array") {
            return $requete2;
        }
    }

    public function getAllContenusByRubrique($id, $dataType) {

        //var_dump($id);
        $count = 0;
        $count2 = -1;
        $sousrubriqueDao = new Sousrubriquedao();

        $requete = $this->dbGateway->prepare("
		SELECT c.*
		FROM contenu c
                JOIN sousrubrique sr on sr.id = c.sousrubriques_id
                JOIN rubrique r on r.id = sr.rubriques_id
                WHERE r.id = :idrub AND c.rang > -1 AND sr.rang > -1
		ORDER BY sr.rang, c.rang
		")or die(print_r($this->dbGateway->error_info()));
        //WHERE r.id = :idrub AND c.rang > -1 AND sr.rang > -1
        //WHERE r.id = :idrub AND c.rang > -1 AND sr.rang > -1 AND c.type = '".ContenuType::$htmlcontent."'
        $requete->execute(array(
            'idrub' => $id));

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if ($dataType == "object") {
            //Put result in an array of objects
            $arrayOfContenustep1 = array();
            $arrayOfContenustep2 = array();
            $arrayOfContenustep3 = array();

            $sousrub = "";
            if (is_array($requete2)) {
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['sousrubriques_id'] != null && $value['sousrubriques_id'] != "") {

                        //$sousrubrique = $sousrubriqueDao->getSousrubrique($value['sousrubriques_id']);
                        if ($sousrub != $value['sousrubriques_id']) {
                            $count2++;
                            $count = 0;
                        }

                        $sousrub = $value['sousrubriques_id'];

                        $arrayOfContenustep1[$count]['id'] = $value['contenu_id'];
                        $arrayOfContenustep1[$count]['titre'] = $value['titre'];
                        $arrayOfContenustep1[$count]['soustitre'] = $value['soustitre'];
                        $arrayOfContenustep1[$count]['contenu'] = $value['contenuhtml'];
                        $arrayOfContenustep1[$count]['position'] = $value['rang'];
                        $arrayOfContenustep1[$count]['image'] = $value['image'];
                        $arrayOfContenustep1[$count]['image2'] = $value['image2'];
                        //$arrayOfContenustep1[$count]['sousrubrique'] = $sousrubrique;

                        if (strcasecmp($value['type'], ContenuType::$htmlcontent) == 0 or strcasecmp($value['type'], ContenuType::$galleryItem) == 0) {
                            $arrayOfContenustep2[$count] = Contenu::fromArray($arrayOfContenustep1[$count]);
                        } elseif (strcasecmp($value['type'], ContenuType::$blog) == 0) {
                            $arrayOfContenustep1[$count]['author'] = $value['author'];
                            $arrayOfContenustep1[$count]['themes'] = $value['themes'];
                            $arrayOfContenustep1[$count]['blogdate'] = $value['contenu_date'];
                            $arrayOfContenustep1[$count]['text1'] = $value['othertext1'];
                            $arrayOfContenustep1[$count]['text2'] = $value['othertext2'];
                            $arrayOfContenustep1[$count]['text3'] = $value['othertext3'];

                            $arrayOfContenustep2[$count] = Blogcontent::fromArray($arrayOfContenustep1[$count]);
                        }

                        $arrayOfContenustep3[$count2][$count] = $arrayOfContenustep2[$count];

                        $count++;
                    }
                }
            }

            return $arrayOfContenustep3;
        } elseif ($dataType == "array") {
            return $requete2;
        }
    }

    public function getAllContenusByRubriqueName($rubName, $limit, $typeContenu, $dataType) {

        //var_dump($id);
        $count = 0;
        $count2 = -1;
        $sousrubriqueDao = new Sousrubriquedao();

        $requete = $this->dbGateway->prepare("
		SELECT c.*
		FROM contenu c
                JOIN sousrubrique sr on sr.id = c.sousrubriques_id
                JOIN rubrique r on r.id = sr.rubriques_id
                WHERE c.type = :typeContenu AND LOWER(r.libelle) = LOWER(:rubName) AND c.rang > -1 AND sr.rang > -1
		ORDER BY sr.rang, c.rang
                LIMIT :limit
		")or die(print_r($this->dbGateway->error_info()));

        $requete->bindParam(':typeContenu', $typeContenu, \PDO::PARAM_STR);
        $requete->bindParam(':rubName', $rubName, \PDO::PARAM_STR);
        $requete->bindParam(':limit', $limit, \PDO::PARAM_INT);

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        //var_dump($requete2);
        //exit();
        if ($dataType == "object") {
            //Put result in an array of objects
            $arrayOfContenustep1 = array();
            $arrayOfContenustep2 = array();
            $arrayOfContenustep3 = array();

            $sousrub = "";
            if (is_array($requete2)) {
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['sousrubriques_id'] != null && $value['sousrubriques_id'] != "") {

                        //$sousrubrique = $sousrubriqueDao->getSousrubrique($value['sousrubriques_id']);
                        if ($sousrub != $value['sousrubriques_id']) {
                            $count2++;
                            $count = 0;
                        }

                        $sousrub = $value['sousrubriques_id'];

                        $arrayOfContenustep1[$count]['id'] = $value['contenu_id'];
                        $arrayOfContenustep1[$count]['titre'] = $value['titre'];
                        $arrayOfContenustep1[$count]['soustitre'] = $value['soustitre'];
                        $arrayOfContenustep1[$count]['contenu'] = $value['contenuhtml'];
                        $arrayOfContenustep1[$count]['position'] = $value['rang'];
                        $arrayOfContenustep1[$count]['image'] = $value['image'];
                        $arrayOfContenustep1[$count]['image2'] = $value['image2'];
                        //$arrayOfContenustep1[$count]['sousrubrique'] = $sousrubrique;

                        if (strcasecmp($value['type'], ContenuType::$htmlcontent) == 0 or strcasecmp($value['type'], ContenuType::$galleryItem) == 0) {
                            $arrayOfContenustep2[$count] = Contenu::fromArray($arrayOfContenustep1[$count]);
                        } elseif (strcasecmp($value['type'], ContenuType::$blog) == 0) {
                            $arrayOfContenustep1[$count]['author'] = $value['author'];
                            $arrayOfContenustep1[$count]['themes'] = $value['themes'];
                            $arrayOfContenustep1[$count]['blogdate'] = $value['contenu_date'];
                            $arrayOfContenustep1[$count]['text1'] = $value['othertext1'];
                            $arrayOfContenustep1[$count]['text2'] = $value['othertext2'];
                            $arrayOfContenustep1[$count]['text3'] = $value['othertext3'];

                            $arrayOfContenustep2[$count] = Blogcontent::fromArray($arrayOfContenustep1[$count]);
                        }

                        $arrayOfContenustep3[$count2][$count] = $arrayOfContenustep2[$count];

                        $count++;
                    }
                }
            }

            return $arrayOfContenustep3;
        } elseif ($dataType == "array") {
            return $requete2;
        }
    }

    public function getContenu($id) {

        $id = (int) $id;
        $result = array();

        $sousrubriqueDao = new SousRubriqueDao();
        $contenustep1 = array();

        $requete = $this->dbGateway->prepare("
		SELECT *
		FROM contenu c
		WHERE c.contenu_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        $sousrubrique = $sousrubriqueDao->getSousrubrique($requete2['sousrubriques_id']);

        $contenustep1['id'] = $requete2['contenu_id'];
        $contenustep1['titre'] = $requete2['titre'];
        $contenustep1['soustitre'] = $requete2['soustitre'];
        $contenustep1['contenu'] = $requete2['contenuhtml'];
        $contenustep1['position'] = $requete2['rang'];
        $contenustep1['image'] = $requete2['image'];
        $contenustep1['image2'] = $requete2['image2'];
        $contenustep1['sousrubrique'] = $sousrubrique;
        $contenustep1['type'] = $requete2['type'];
        /*
          $contenustep1['']=$requete2['author'];
          $contenustep1['']=$requete2['themes'];
          $contenustep1['']=$requete2['contenu_date'];
          $contenustep1['']=$requete2['othertext1'];
          $contenustep1['']=$requete2['othertext2'];
          $contenustep1['']=$requete2['othertext3'];
         */
        $contenu = Contenu::fromArray($contenustep1);

        return $contenu;
    }

    public function getContenusBySousrubrique($sousrubriqueid, $dataType) {

        $sousrubriqueid = (int) $sousrubriqueid;
        $result = array();

        $sousrubriqueDao = new SousRubriqueDao();
        $contenustep1 = array();

        $requete = $this->dbGateway->prepare("
		SELECT *
		FROM contenu
		WHERE sousrubriques_id = :id
                ORDER BY rang
		")or die(print_r($this->dbGateway->error_info()));
        //WHERE c.sousrubriques_id = :id AND c.type = '".ContenuType::$htmlcontent."'
        $requete->execute(array(
            'id' => $sousrubriqueid
        ));

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if ($dataType == "object") {
            //Put result in an array of objects
            $arrayOfContenustep1 = array();
            $arrayOfContenustep2 = array();

            if (is_array($requete2)) {
                $count = 0;
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['sousrubriques_id'] != null && $value['sousrubriques_id'] != "") {

                        $sousrubrique = $sousrubriqueDao->getSousrubrique($value['sousrubriques_id']);

                        $arrayOfContenustep1[$count]['id'] = $value['contenu_id'];
                        $arrayOfContenustep1[$count]['titre'] = $value['titre'];
                        $arrayOfContenustep1[$count]['soustitre'] = $value['soustitre'];
                        $arrayOfContenustep1[$count]['contenu'] = $value['contenuhtml'];
                        $arrayOfContenustep1[$count]['position'] = $value['rang'];
                        $arrayOfContenustep1[$count]['image'] = $value['image'];
                        $arrayOfContenustep1[$count]['image2'] = $value['image2'];
                        $arrayOfContenustep1[$count]['type'] = $value['type'];
                        $arrayOfContenustep1[$count]['sousrubrique'] = $sousrubrique;

                        if (strcasecmp($value['type'], ContenuType::$htmlcontent) == 0 or strcasecmp($value['type'], ContenuType::$galleryItem) == 0) {
                            $arrayOfContenustep2[$count] = Contenu::fromArray($arrayOfContenustep1[$count]);
                        } elseif (strcasecmp($value['type'], ContenuType::$blog) == 0) {
                            $arrayOfContenustep1[$count]['author'] = $value['author'];
                            $arrayOfContenustep1[$count]['themes'] = $value['themes'];
                            $arrayOfContenustep1[$count]['blogdate'] = $value['contenu_date'];
                            $arrayOfContenustep1[$count]['text1'] = $value['othertext1'];
                            $arrayOfContenustep1[$count]['text2'] = $value['othertext2'];
                            $arrayOfContenustep1[$count]['text3'] = $value['othertext3'];

                            $arrayOfContenustep2[$count] = Blogcontent::fromArray($arrayOfContenustep1[$count]);
                        }

                        $count++;
                    }
                }
            }

            return $arrayOfContenustep2;
        } elseif ($dataType == "array") {
            return $requete2;
        }
    }

    public function saveContenu(Contenu $contenu) {

        $id = (int) $contenu->getId();

        //var_dump($contenu);
        //exit;
        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
				UPDATE contenu 
				SET titre= :titre, 
				soustitre = :soustitre,
				sousrubriques_id = :sousrubriques_id,
				contenuhtml = :contenuhtml,
                                rang = :rang,
                                image = :image,
                                image2 = :image2
				WHERE contenu_id = :id
			")or die(print_r($this->dbGateway->errors_info()));

            $requete->execute(array(
                'id' => $id,
                'titre' => $contenu->getTitre(),
                'soustitre' => $contenu->getSousTitre(),
                'rang' => $contenu->getRang(),
                'image' => $contenu->getImage(),
                'image2' => $contenu->getImage2(),
                'sousrubriques_id' => $contenu->getSousRubrique()->getId(),
                'contenuhtml' => $contenu->getContenuHtml()
            ));
        } else {
            $requete = $this->dbGateway->prepare("INSERT into contenu(titre,soustitre,sousrubriques_id,contenuhtml, rang, image, image2, type) 
					values(:titre, :soustitre,:sousrubriques_id,:contenuhtml, :rang, :image, :image2, :type)")or die(print_r($this->dbGateway->error_info()));

            $requete->execute(array(
                'titre' => $contenu->getTitre(),
                'soustitre' => $contenu->getSousTitre(),
                'sousrubriques_id' => $contenu->getSousRubrique()->getId(),
                'contenuhtml' => $contenu->getContenuHtml(),
                'rang' => $contenu->getRang(),
                'image' => $contenu->getImage(),
                'image2' => $contenu->getImage2(),
                'type' => $contenu->getType()
            ));
        }
    }

    public function updateContenuPosition($id, $position) {

        $id = (int) $id;

        //var_dump($contenu);
        //exit;
        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
				UPDATE contenu 
				SET rang = :rank
                                WHERE contenu_id = :id
			")or die(print_r($this->dbGateway->errors_info()));

            $result = $requete->execute(array(
                'id' => $id,
                'rank' => $position
            ));

            return $result;
        } else {
            return false;
        }
    }

    public function deleteContenu($id) {

        $id = (int) $id;
        //echo $id;
        //fonction pour afficher la liste des tracteurs sous forme de tableau
        $requete = $this->dbGateway->prepare("
		DELETE FROM contenu WHERE contenu_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));
    }

}