<?php

/*
 * Copyright (C) 2014 BOFH873
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

/**
 * Description of Category
 *
 * @author BOFH873
 */
class Category {

    // ID univoco
    private $id;
    // Nome
    private $name;
    // Array delle sottocategorie
    private $children;

    /**
     * Costruttore privato, verrà chiamato solo all'interno della stessa classe
     * dai builder.
     * 
     * @param array $data Array associativo contenente il record della
     *                     categoria (uno degli array restituiti da
     *                     fetch_all()).
     * 
     */
    private function __construct($data)
    {
        $this->id = $data["id"];
        $this->name = $data["name"];
    }
    
    /**
     * Effettua una query del database per estrarre tutti i record delle
     * categorie.
     * 
     * @param int $top ID della categoria dalla quale partire, di default è 1, 
     *                  ovvero l'ID della categoria "root".
     * 
     * @param array $result Array contenente le risposte del database (ricavato
     *                       da fetch_all()). Utilizzato solo internamente per 
     *                       evitare di fare query multiple.
     * 
     * @return array|null Restituisce un array di Category popolato con i dati
     *                     delle categorie di primo livello (parent == 1),
     *                     oppure con le sottocategorie che hanno parent $top.
     */
    public static function getCategories($top = 1, $result = null)
    {
        
        if (is_null($result))
        {
            include_once __DIR__."/../Database.php";
            
            Database::safeStart();

            $query = "SELECT * FROM categories;";

            $result_mysqli = Database::$mysqli->query($query);
            $result = $result_mysqli->fetch_all(MYSQLI_ASSOC);
        }
        
        
        $return_array = null;
        
        foreach ($result as $row) {
            if ($row["parent_id"] == $top)
            {
                $temp = new Category($row);
                $temp->children = self::getCategories($temp->id, $result);
                $return_array[] = $temp;
            }
        }
        
        return $return_array;
    }
    
    /**
     * Effettua una query del database per estrarre tutti i record delle
     * categorie, restituendole sotto forma di array e non di albero.
     * 
     * @return array|null Restituisce un array di Category popolato con i dati
     *                    di tutte le categorie, senza distinzioni di livello.
     */
    public static function getCategoriesArray()
    {
        
        include_once __DIR__."/../Database.php";

        Database::safeStart();

        $query = "SELECT * FROM categories;";

        $result_mysqli = Database::$mysqli->query($query);
        $result = $result_mysqli->fetch_all(MYSQLI_ASSOC);

        $return_array = null;
        
        foreach ($result as $row)
        {
            $return_array[] = new Category($row);
        }
        
        return $return_array;
    }
        
    /**
     * Prende in input un array di Category e restituisce una stringa con la
     * rappresentazione HTML (lista non ordinata) della struttura delle
     * categorie.
     * 
     * @param array $catArray L'array di categorie da stampare.
     * 
     * @return string Stringa con la rappresentazione HTML delle categorie
     */
    public static function printArray($catArray)
    {
        $string = "<ul>\n";
        foreach ($catArray as $category)
        {
            $string .= $category->__toString();
        }
        $string .= "</ul>\n";
        
        return $string;
    }
    
    public function __toString()
    {
        if (!count($this->children))
        {
            $string = "<li>$this->name</li>\n";
        }
        else
        {
            $string = "<li>$this->name\n<ul>";
            foreach ($this->children as $category)
            {
                $string .= $category->__toString();
            }
            $string .= "</ul>\n</li>";
        }
        
        return $string;
    }        
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getChildren() {
        return $this->children;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setChildren($children) {
        $this->children = $children;
    }

}
