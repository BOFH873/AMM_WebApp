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
    public static function &getProducts($disabled = 0)
    {
        if (!$disabled) { $disabled_string = " WHERE disabled=false"; }
        else { $disabled_string = "";}
        
        include_once "Database.php";
        $return_array = array();
        
        Database::safeStart();
        
        $query = "SELECT * FROM products".$disabled_string.";";
        
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
    public static function &getProductsByName($pattern)
    {
        include_once "Database.php";
        $return_array = array();
        
        Database::safeStart();
        
        $stmt = Database::$mysqli->stmt_init();
        $query = "SELECT * FROM products WHERE name LIKE ?;";
        $stmt->prepare($query);
        $stmt->bind_param("s", $pattern);
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_object()) {
            $return_array[] = new Product($row);
        }
        
        return $return_array;
    }
    
    public function __toString()
    {
        $string = "ID: $this->id\n".
                "  name = $this->username\n".
                "  stock_qty = $this->password\n".
                "  category_id = $this->name\n".
                "  price = $this->last_name\n".
                "  description = $this->address\n";
        
        return $string;
    }
}
