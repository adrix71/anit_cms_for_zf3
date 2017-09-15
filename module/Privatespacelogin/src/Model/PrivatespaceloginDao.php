<?php

namespace Privatespacelogin\Model;

use Application\DBConnection\ParentDao;
use Privatespacelogin\Model\Privatespacelogin;

class PrivatespaceloginDao extends ParentDao {

    public function __construct() {
        parent::__construct();
    }

    public function getAllLogin($dataType) {

        $requete = $this->dbGateway->prepare("
		SELECT privatespacelogin_id, space_id_fk,  
                privatespacelogin_pwd, privatespacelogin_email,
                privatespacelogin_firstname,privatespacelogin_lastname,
                privatespacelogin_company,privatespacelogin_streetnumber,
                privatespacelogin_streetline_1,privatespacelogin_streetline_2,privatespacelogin_streetline_3,
                privatespacelogin_zipcode,privatespacelogin_city,privatespacelogin_homephone,
                privatespacelogin_mobilephone,privatespacelogin_website, privatespacelogin_validate
		FROM privatespacelogin
		ORDER BY privatespacelogin_email
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if ($dataType == "object") {
            //Put result in an array of objects
            $arrayOfUsers = array();
            if (is_array($requete2)) {
                foreach ($requete2 as $value) {
                    //put code to define an array of objects
                    if ($value['id_access'] != null && $value['id_access'] != "") {
                        $arrayOfUsers[] = Login::fromArray($value);
                    }
                }
            }
            return $arrayOfUsers;
        } elseif ($dataType == "array") {
            return $requete2;
        }
    }

    public function getAllLoginBySpace($id, $dataType) {

        $requete = $this->dbGateway->prepare("
		SELECT privatespacelogin_id, space_id_fk,  
                privatespacelogin_pwd, privatespacelogin_email,
                privatespacelogin_firstname,privatespacelogin_lastname,
                privatespacelogin_company,privatespacelogin_streetnumber,
                privatespacelogin_streetline_1,privatespacelogin_streetline_2,privatespacelogin_streetline_3,
                privatespacelogin_zipcode,privatespacelogin_city,privatespacelogin_homephone,
                privatespacelogin_mobilephone,privatespacelogin_website, privatespacelogin_validate
		FROM privatespacelogin
                WHERE space_id_fk = :id
		ORDER BY privatespacelogin_email
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(
                array(
                    'id' => $id
        ));

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if ($dataType == "object") {
            //Put result in an array of objects
            $arrayOfUsers = array();
            if (is_array($requete2)) {
                foreach ($requete2 as $value) {
                    //put code to define an array of objects
                    if ($value['privatespacelogin_id'] != null && $value['privatespacelogin_id'] != "") {
                        $arrayOfUsers[] = Privatespacelogin::fromArray($value);
                    }
                }
            }
            return $arrayOfUsers;
        } elseif ($dataType == "array") {
            return $requete2;
        }
    }

    public function countLoginByEmailAndPrivatespace($spaceId, $email) {

        $requete = $this->dbGateway->prepare("
		SELECT COUNT(privatespacelogin_email)
		FROM privatespacelogin
		WHERE space_id_fk = :spaceId AND privatespacelogin_email = :email
                ")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'spaceId' => $spaceId,
            'email' => $email
        ));

        return (int) $requete->fetchColumn();
    }

    public function countLoginByEmail($email) {

        $requete = $this->dbGateway->prepare("
		SELECT COUNT(privatespacelogin_email)
		FROM privatespacelogin
		WHERE privatespacelogin_email = :email
                ")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'email' => $email
        ));
        return (int) $requete->fetchColumn();
    }

    public function getLogin($id) {

        $id = (int) $id;
        $result = array();

        $requete = $this->dbGateway->prepare("
		SELECT privatespacelogin_id, space_id_fk,  
                privatespacelogin_pwd, privatespacelogin_email,
                privatespacelogin_firstname,privatespacelogin_lastname,
                privatespacelogin_company,privatespacelogin_streetnumber,
                privatespacelogin_streetline_1,privatespacelogin_streetline_2,privatespacelogin_streetline_3,
                privatespacelogin_zipcode,privatespacelogin_city,privatespacelogin_homephone,
                privatespacelogin_mobilephone,privatespacelogin_website, privatespacelogin_validate
		FROM privatespacelogin
		WHERE privatespacelogin_id = :id
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);
        //var_dump($requete2);
        $result = Privatespacelogin::fromArray($requete2);

        return $result;
    }

    public function getLoginByEmail($email) {

        $requete = $this->dbGateway->prepare("
		SELECT privatespacelogin_id, space_id_fk,  
                privatespacelogin_pwd, privatespacelogin_email,
                privatespacelogin_firstname,privatespacelogin_lastname,
                privatespacelogin_company,privatespacelogin_streetnumber,
                privatespacelogin_streetline_1,privatespacelogin_streetline_2,privatespacelogin_streetline_3,
                privatespacelogin_zipcode,privatespacelogin_city,privatespacelogin_homephone,
                privatespacelogin_mobilephone,privatespacelogin_website, privatespacelogin_validate
		FROM privatespacelogin
		WHERE privatespacelogin_email = :email
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'email' => $email
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);
        //var_dump($requete2);
        $result = Privatespacelogin::fromArray($requete2);

        return $result;
    }

    public function getLoginByEmailAndPassword($email, $pwd) {

        $requete = $this->dbGateway->prepare("
		SELECT privatespacelogin_id, space_id_fk,  
                privatespacelogin_pwd, privatespacelogin_email,
                privatespacelogin_firstname,privatespacelogin_lastname,
                privatespacelogin_company,privatespacelogin_streetnumber,
                privatespacelogin_streetline_1,privatespacelogin_streetline_2,privatespacelogin_streetline_3,
                privatespacelogin_zipcode,privatespacelogin_city,privatespacelogin_homephone,
                privatespacelogin_mobilephone,privatespacelogin_website, privatespacelogin_validate
		FROM privatespacelogin
		WHERE privatespacelogin_email = :email AND privatespacelogin_pwd = :pwd
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'email' => $email,
            'pwd' => $pwd
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);
        //var_dump($requete2);
        $result = Privatespacelogin::fromArray($requete2);

        return $result;
    }

    public function updateLastConnection($id) {
        $requete = $this->dbGateway->prepare("
		UPDATE privatespacelogin SET privatespacelogin_lastconn = now()
                WHERE privatespacelogin_id = :id
			")or die(print_r($this->dbGateway->errors_info()));

        $requete->execute(array(
            'id' => $id
        ));
    }

    public function saveLogin(Privatespacelogin $login) {

        $id = (int) $login->getId();
        $nbRowSaved = 0;

        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
		UPDATE privatespacelogin SET space_id_fk = :space_id, privatespacelogin_pwd = :pwd, privatespacelogin_email = :email, privatespacelogin_firstname = :firstname, privatespacelogin_lastname = :lastname, privatespacelogin_company = :company, privatespacelogin_streetnumber = :streetnumber, privatespacelogin_streetline_1 = :streetline_1, privatespacelogin_streetline_2 = :streetline_2, privatespacelogin_streetline_3 = :streetline_3, privatespacelogin_zipcode = :zipcode, privatespacelogin_city = :city, privatespacelogin_homephone = :homephone, privatespacelogin_mobilephone = :mobilephone, privatespacelogin_website = :website, privatespacelogin_validate = :validate
                WHERE privatespacelogin_id = :id
			")or die(print_r($this->dbGateway->errors_info()));

            $nbRowSaved = $requete->execute(array(
                'id' => $id,
                'space_id' => $login->getSpace()->getId(),
                'pwd' => $login->getPwd(),
                'email' => $login->getEmail(),
                'firstname' => $login->getFirstname(),
                'lastname' => $login->getLastname(),
                'company' => $login->getCompany(),
                'streetnumber' => $login->getStreetnumber(),
                'streetline_1' => $login->getStreetline_1(),
                'streetline_2' => $login->getStreetline_2(),
                'streetline_3' => $login->getStreetline_3(),
                'zipcode' => $login->getZipcode(),
                'city' => $login->getCity(),
                'homephone' => $login->getHomephone(),
                'mobilephone' => $login->getMobilephone(),
                'website' => $login->getWebsite(),
                'validate' => $login->getIsValidate()
            ));
        } else {

            $requete = $this->dbGateway->prepare("INSERT into privatespacelogin(space_id_fk, privatespacelogin_pwd, privatespacelogin_email, privatespacelogin_firstname, privatespacelogin_lastname, privatespacelogin_company, privatespacelogin_streetnumber, privatespacelogin_streetline_1, privatespacelogin_streetline_2, privatespacelogin_streetline_3, privatespacelogin_zipcode, privatespacelogin_city, privatespacelogin_homephone, privatespacelogin_mobilephone, privatespacelogin_website, privatespacelogin_validate) 
					values(:space_id, :pwd, :email, :firstname, :lastname, :company, :streetnumber, :streetline_1, :streetline_2, :streetline_3, :zipcode, :city, :homephone, :mobilephone, :website, :validate)")or die(print_r($this->dbGateway->error_info()));

            $nbRowSaved = $requete->execute(array(
                'space_id' => $login->getSpace()->getId(),
                'pwd' => $login->getPwd(),
                'email' => $login->getEmail(),
                'firstname' => $login->getFirstname(),
                'lastname' => $login->getLastname(),
                'company' => $login->getCompany(),
                'streetnumber' => $login->getStreetnumber(),
                'streetline_1' => $login->getStreetline_1(),
                'streetline_2' => $login->getStreetline_2(),
                'streetline_3' => $login->getStreetline_3(),
                'zipcode' => $login->getZipcode(),
                'city' => $login->getCity(),
                'homephone' => $login->getHomephone(),
                'mobilephone' => $login->getMobilephone(),
                'website' => $login->getWebsite(),
                'validate' => $login->getIsValidate()
            ));
        }
        
        return $nbRowSaved;
    }

    public function deleteLogin($id) {

        $id = (int) $id;
        $requete = $this->dbGateway->prepare("
		DELETE FROM privatespacelogin WHERE privatespacelogin_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));
    }

}
