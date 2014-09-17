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
    // ID del padre
    private $parent_id;

    /**
     * Costruttore privato, verrà chiamato solo all'interno della stessa classe
     * dai builder.
     * 
     * @param array $data Array associativo contenente il record della
     *                     categoria.
     * 
     */
    private function __construct($data)
    {
        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->parent_id = $data["parent_id"];
    }
    
    /**
     * Effettua una query del database per estrarre tutti i record delle
     * categorie.
     * 
     * @param int $top ID della categoria dalla quale partire, di default è 1, 
     *                  ovvero l'ID della categoria "root".
     * 
     * @param array $result Array contenente le risposte del database.
     *                      Utilizzato solo internamente per evitare di fare
     *                      query multiple.
     * 
     * @return array|null Restituisce un array di Category popolato con i dati
     *                     delle categorie di primo livello (parent == 1),
     *                     oppure con le sottocategorie che hanno parent $top.
     */
    public static function getCategories($top = 1, $result = null)
    {
        
        if (is_null($result))
        {
            require_once __DIR__."/../Database.php";
            
            Database::safeStart();

            $query = "SELECT * FROM categories;";

            $result_mysqli = Database::$mysqli->query($query);       
            $result = array();
            while ($row = $result_mysqli->fetch_assoc())
            {
                $result[] = $row;
            }
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
        
        require_once __DIR__."/../Database.php";

        Database::safeStart();

        $query = "SELECT * FROM categories;";

        $result_mysqli = Database::$mysqli->query($query);
        $result = array();
        while ($row = $result_mysqli->fetch_assoc())
        {
            $result[] = $row;
        }

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
    
    public static function catHierarchyString($catArray, $category)
    {
        if ($category->getParent_id() == 1
                || $category->getParent_id() == NULL)
        {
            return $category->getName();
        }
        
        foreach($catArray as $cat)
        {
            if ($cat->getId() == $category->getParent_id())
            {
                $return_string = self::catHierarchyString($catArray, $cat);
                $return_string .= " -&gt; "
                        .$category->getName();
                return $return_string;
            }
        }
    }
    
    public static function createCategory($newCategory)
    {
        require_once __DIR__."/../Database.php";

        Database::safeStart();

        $stmt = Database::$mysqli->stmt_init();
        $query = "INSERT INTO categories"
                . " (name,"
                . " parent_id)"
                . " VALUES"
                . " (?,"
                . " ?)";

        $stmt->prepare($query);
                
        $stmt->bind_param("si",
                $newCategory->name,
                $newCategory->parent_id);

        $stmt->execute();

   }

    public static function updateCategory($editCategory)
    {
        require_once __DIR__."/../Database.php";
        
        Database::safeStart();
        
        $stmt = Database::$mysqli->stmt_init();

        $query = "UPDATE categories SET"
                ." name=?,"
                ." parent_id=?"
                ." WHERE id=?";

        $stmt->prepare($query);
        $stmt->bind_param("sss",
                $editCategory->name,
                $editCategory->parent_id,
                $editCategory->id);

        $stmt->execute();
        
    }

    public static function catChildIdString($category)
    {
        $return_string = "";

        $children = $category->children;
        if (is_array($children))
        {
            foreach ($children as $child)
            {
                $return_string .= self::catChildIdString($child);
            }
        }

        $return_string .= $category->id . ", ";

        return $return_string;
    }
   
    public static function deleteCatAndChildren($category)
    {
        require_once __DIR__."/../Database.php";
        
        Database::safeStart();
        
        $query = "DELETE FROM categories WHERE id IN ("
                . self::catChildIdString($category)
                . "-1);";

        Database::$mysqli->query($query);
        
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
    
    public function getParent_id() {
        return $this->parent_id;
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

    public function setParent_id($parent_id) {
        $this->parent_id = $parent_id;
    }

}
