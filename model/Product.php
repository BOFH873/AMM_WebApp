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
 * Description of Product
 *
 * @author BOFH873
 */
class Product {
    
    // ID univoco
    private $id;
    // Nome prodotto
    private $name;
    // Quantità in stock
    private $stock_qty;
    // ID categoria
    private $category_id;
    // Prezzo
    private $price;
    // Descrizione completa
    private $description;
    // Foto del prodotto
    private $picture;
    // Tipo dei dati della foto
    private $mimetype;
    
    /**
     * Costruttore privato, verrà chiamato solo all'interno della stessa classe
     * dai builder.
     * 
     * @param Obj $data Oggetto contenente il record del prodotto (uno degli
     *                   oggetti restituiti da fetch_object()).
     * 
     */
    private function __construct($data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->stock_qty = $data->stock_qty;
        $this->category_id = $data->category_id;
        $this->price = $data->price;
        $this->description = $data->description;
        
        if (property_exists($data, "picture"))
        {
            $this->picture = $data->picture;
            $this->mimetype = $data->mimetype;
        }
    }
    
    /**
     * Effettua una query del database per estrarre tutti i record dei prodotti
     * 
     * @param bool $disabled Flag per escludere i prodotti disabilitati
     *                        (comportamento di default) o includerli quando
     *                        assume il valore true.
     * 
     * @return array|null Restituisce un array di Product popolato con i dati
     *                     di tutti i Prodotti.
     */
    public static function getProducts($disabled = 0)
    {
        if (!$disabled) { $disabled_string = " WHERE disabled=false"; }
        else { $disabled_string = "";}
        
        include_once __DIR__."/../Database.php";
        $return_array = array();
        
        Database::safeStart();
        
        $query = "SELECT"
                . " id,"
                . " name,"
                . " stock_qty,"
                . " category_id,"
                . " price,"
                . " description,"
                . " disabled"
                . " FROM products"
                . $disabled_string
                . ";";
        
        $result = Database::$mysqli->query($query);
        while ($row = $result->fetch_object()) {
            $return_array[] = new Product($row);
        }
        
        return $return_array;
    }
    
    /**
     * Effettua una query del database per estrarre i record dei prodotti che
     * contengono la stringa specificata come parametro.
     * 
     * @param string $pattern Pattern da cercare nel nome del prodotto.
     * 
     * @return array|null Restituisce un array con tutti i prodotti che
     *                     corrispondono al pattern di ricerca oppure null se
     *                     la ricerca non da risultati.
     */
    public static function getProductsByName($pattern)
    {
        include_once __DIR__."/../Database.php";
        $return_array = array();
        
        Database::safeStart();
        
        $stmt = Database::$mysqli->stmt_init();
        $query = "SELECT"
                . " id,"
                . " name,"
                . " stock_qty,"
                . " category_id,"
                . " price,"
                . " description,"
                . " picture,"
                . " mimetype,"
                . " disabled"
                . " FROM products"
                . "WHERE name LIKE ?;";
        $stmt->prepare($query);
        $stmt->bind_param("s", $pattern);
        $stmt->execute();
        $stmt->store_result();        
        
        $obj = new stdClass();
        
        $stmt->bind_result($obj->id,
                $obj->name,
                $obj->stock_qty,
                $obj->category_id,
                $obj->price,
                $obj->description,
                $obj->picture,
                $obj->mimetype,
                $obj->disabled);

        while ($stmt->fetch())
        {
            $return_array[] = new Product($obj);
        }
                
        return $return_array;
    }
    
    /**
     * Effettua una query del database per estrarre i dati del prodotto con l'id
     * specificato
     * 
     * @param int $id ID del prodotto desiderato.
     * 
     * @return    Product|false    Restituisce un Product se la query è andata a
     *                             buon fine, altrimenti restituisce false.
     */
    public static function getProductByID($id)
    {
        include_once __DIR__."/../Database.php";

        Database::safeStart();

        $stmt = Database::$mysqli->stmt_init();
        $query = "SELECT"
                . " id,"
                . " name,"
                . " stock_qty,"
                . " category_id,"
                . " price,"
                . " description,"
                . " picture,"
                . " mimetype,"
                . " disabled"
                . " FROM products"
                . " WHERE id=? LIMIT 1;";
        $stmt->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        
        $obj = new stdClass();
        
        $stmt->bind_result($obj->id,
                $obj->name,
                $obj->stock_qty,
                $obj->category_id,
                $obj->price,
                $obj->description,
                $obj->picture,
                $obj->mimetype,
                $obj->disabled);

        if ($stmt->num_rows)
        {
            $stmt->fetch();
            return new Product($obj);
        }
        
        return false;
    }
    
    public static function uploadNewProduct($newProduct)
    {
        include_once __DIR__."/../Database.php";

        Database::safeStart();

        $stmt = Database::$mysqli->stmt_init();
        $query = "INSERT INTO products"
                . " (name,"
                . " stock_qty,"
                . " category_id,"
                . " price,"
                . " description,"
                . " picture,"
                . " mimetype)"
                . " VALUES"
                . " (?,"
                . " ?,"
                . " ?,"
                . " ?,"
                . " ?,"
                . " LOAD_FILE(?),"
                . " ?)";

        $stmt->prepare($query);
                
        $picValue = property_exists($newProduct, "picture")
                ? $newProduct->picture
                : NULL;
        $mimeValue = property_exists($newProduct, "picture")
                ? $newProduct->mimetype
                : NULL;

        $stmt->bind_param("siidsss",
                $newProduct->name,
                $newProduct->stock_qty,
                $newProduct->category_id,
                $newProduct->price,
                $newProduct->description,
                
                $picValue,
                $mimeValue);

                $stmt->execute();

   }
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getStock_qty() {
        return $this->stock_qty;
    }

    public function getCategory_id() {
        return $this->category_id;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getDescription() {
        return $this->description;
    }
    
    public function getPicture() {
        return $this->picture;
    }
    
    public function getMimetype() {
        return $this->mimetype;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setStock_qty($stock_qty) {
        $this->stock_qty = $stock_qty;
    }

    public function setCategory_id($category_id) {
        $this->category_id = $category_id;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function setPicture($picture) {
        $this->picture = $picture;
    }

    public function setMimetype($mimetype) {
        $this->mimetype = $mimetype;
    }

    public function __toString()
    {
        $string = "ID: $this->id<br/>\n".
                "  name = $this->name<br/>\n".
                "  stock_qty = $this->stock_qty<br/>\n".
                "  category_id = $this->category_id<br/>\n".
                "  price = $this->price<br/>\n".
                "  description = $this->description<br/>\n";
        
        return $string;
    }
}
