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
 * Description of Transaction
 *
 * @author BOFH873
 */
class Transaction {
    
    // ID univoco
    private $id;
    // ID utente
    private $user_id;
    // ID prodotto venduto
    private $product_id;
    // Numero di pezzi
    private $qty;
    // Totale pagato
    private $total;
    // Data vendita
    private $date;
    
    /**
     * Costruttore privato, verrà chiamato solo all'interno della stessa classe
     * dai builder.
     * 
     * @param Obj $data Oggetto contenente il record della vendita (uno degli
     *                   oggetti restituiti da fetch_object()).
     * 
     */
    private function __construct($data)
    {
        $this->id = $data->id;
        $this->user_id = $data->user_id;
        $this->product_id = $data->product_id;
        $this->qty = $data->qty;
        $this->total = $data->total;
        $this->date = $data->date;
    }
    
    /**
     * Effettua una query del database per estrarre tutti i record delle
     * vendite.
     * 
     * @return array|null Restituisce un array di Transaction popolato con i
     *                     dati di tutte le vendite.
     */
    public static function &getTransactions()
    {
        include_once "Database.php";
        $return_array = array();
        
        Database::safeStart();
        
        $query = "SELECT * FROM sales;";
        
        $result = Database::$mysqli->query($query);
        while ($row = $result->fetch_object()) {
            $return_array[] = new Transaction($row);
        }
        
        return $return_array;
    }
    
    /**
     * Effettua una query del database per estrarre il record delle vendite
     * relative allo user ID specificato
     * 
     * @param int $user_id ID utente da cercare nel database.
     * 
     * @return array|null Restituisce un array delle transazioni oppure null se
     *                     la ricerca non da risultati.
     */
    public static function &getTransactionsByID($user_id)
    {
        include_once "Database.php";
        
        Database::safeStart();
        
        $stmt = Database::$mysqli->stmt_init();
        $query = "SELECT * FROM users WHERE user_id=?;";
        $stmt->prepare($query);
        $stmt->bind_param("i", $user_id);
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_object()) {
            $return_array[] = new Transaction($row);
        }
        
        return $return_array;
    }
    
    public function __toString()
    {
        $string = "ID: $this->id<br/>\n".
                "  user_id = $this->user_id<br/>\n".
                "  product_id = $this->product_id<br/>\n".
                "  qty = $this->qty<br/>\n".
                "  total = $this->total<br/>\n".
                "  date = $this->date<br/>\n";
        
        return $string;
    }
}
