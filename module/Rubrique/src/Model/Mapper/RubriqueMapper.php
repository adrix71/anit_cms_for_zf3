<?php

namespace Rubrique\Model\Mapper;

use Rubrique\Model\Rubrique;


class RubriqueMapper
{
    public function exchangeArray($data)
    {
        $rubrique = new Rubrique();

        if (isset($data['id'])) {
            $rubrique->setId($data['id']);
        }
        if (isset($data['libelle'])) {
            $rubrique->setLibelle($data['libelle']);
        }
        if (isset($data['rang'])) {
            $rubrique->setRang($data['rang']);
        }
        if (isset($data['scope'])) {
            $rubrique->setScope($data['scope']);
        }
        if (isset($data['spaceId'])) {
            $rubrique->setSpaceId($data['spaceId']);
        }
        if (isset($data['filename'])) {
            $rubrique->setFilename($data['filename']);
        }
        if (isset($data['contactForm'])) {
            $rubrique->setHasContactForm($data['contactForm']);
        }
        if (isset($data['messageForm'])) {
            $rubrique->setHasMessageForm($data['messageForm']);
        }
        if (isset($data['updateForm'])) {
            $rubrique->setHasUpdateForm($data['updateForm']);
        }
        if (isset($data['fileuploadForm'])) {
            $rubrique->setHasFileuploadForm($data['fileuploadForm']);
        }

        return $rubrique;
    }
}