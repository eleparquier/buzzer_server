<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 26/06/15
 * Time: 13:22
 */

namespace fr\manaur\buzzer;


class Numerotation
{
    private $ids = array();

    /**
     * Cherche un id disponible et actualise la liste
     * @return int
     */
    public function getNewId()
    {
        if(count($this->ids) == 0) {
            $id = 1;
        }
        else {
            asort($this->ids);
            $cpt = 1;
            foreach ($this->ids as $curId) {
                if ($curId != $cpt) break;
                $cpt++;
            }
            $id = $cpt;
        }
        $this->ids[$id] = $id;
        return $id;
    }

    /**
     * Enlève un Id de la liste pour le rendre dispo
     * @param int $id
     */
    public function removeId($id)
    {
        $id = (int) preg_replace("#^[^0-9]*([0-9]*)[^0-9]*$#", '$1',$id);
        if(isset($this->ids[$id])) unset($this->ids[$id]);
    }
}