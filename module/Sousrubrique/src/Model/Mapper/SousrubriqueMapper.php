<?php

namespace Sousrubrique\Model\Mapper;

use Sousrubrique\Model\Sousrubrique;


class SousrubriqueMapper
{
    public function exchangeArray($data) {

        $section = new Sousrubrique();

        if (isset($data['id'])) {
            $section->setId($data['id']);
        }
        if (isset($data['libelle'])) {
            $section->setLibelle($data['libelle']);
        }
        if (isset($data['rang'])) {
            $section->setRang($data['rang']);
        }
        if (isset($data['rubrique'])) {
            $section->setRubrique($data['rubrique']);
        }

        return $section;
    }
}