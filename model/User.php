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
 * Description of User
 *
 * @author BOFH873
 */
class User {
    
    // ID univoco
    private $id;
    // Username univoco
    private $username;
    // Password di accesso
    private $password;
    // Nome
    private $name;
    // Cognome
    private $last_name;
    // Indirizzo completo
    private $address;
    
    /**
     * Costruttore privato, verrà chiamato solo all'interno della stessa classe
     * dai builder.
     * 
     * @param Obj $data Oggetto contenente il record dell'utente (uno degli
     *                   oggetti restituiti da fetch_object()).
     * 
     */
    private function __construct($data)
    {
        $this->id = $data->id;
        $this->username = $data->username;
        $this->password = $data->password;
        $this->name = $data->name;
        $this->last_name = $data->last_name;
        $this->address = $data->address;
    }
    
    /**
     * Effettua una query del database per estrarre tutti i record degli utenti
     * 
     * @return array|null Restituisce un array di User popolato con i dati
     *                     di tutti gli utenti.
     */
    public static function getUsers()
    {
        include_once __DIR__."/../Database.php";
        $return_array = array();
        
        Database::safeStart();
        
        $query = "SELECT * FROM users;";
        
        $result = Database::$mysqli->query($query);
        while ($row = $result->fetch_object()) {
            $return_array[] = new User($row);
        }
        
        return $return_array;
    }
    
    /**
     * Effettua una query del database per estrarre il record dell'utente
     * specificato come parametro. 
     * 
     * @param string $username Nome utente da cercare nel database.
     * 
     * @return User|null Restituisce lo User corrispondente oppure null se la
     *                    query non da risultati.
     */
    public static function getUserByUsername($username)
    {
        include_once "Database.php";
        
        Database::safeStart();
        
        $stmt = Database::$mysqli->stmt_init();
        $query = "SELECT"
                . " id,"
                . " username,"
                . " password,"
                . " name,"
                . " last_name,"
                . " address, "
                . " disabled"
                . " FROM users"
                . " WHERE username=?"
                . " LIMIT 1;";
        $stmt->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
                
        $obj = new stdClass();
        
        $stmt->bind_result($obj->id,
                $obj->username,
                $obj->password,
                $obj->name,
                $obj->last_name,
                $obj->address,
                $obj->disabled);
                        
        if ($stmt->num_rows)
        {
            $stmt->fetch();
            return new User($obj);
        }
        else
        {
            return null;
        }
    }
    
    /**
     * Aggiorna la password dell'utente secondo il valore contenuto nella
     * proprietà $this->password.
     */
    public function updatePass()
    {
        include_once "Database.php";
        
        Database::safeStart();
        
        $stmt = Database::$mysqli->stmt_init();
        $query = "UPDATE users SET password=? WHERE id=?";
        $stmt->prepare($query);
        $stmt->bind_param("ss", $this->password, $this->id);
        $stmt->execute();
    }
    
    /**
     * Aggiorna i dati dell'utente secondo i valori contenuti nelle proprietà
     * $this->name, $this->last_name, $this->address.
     */
    public function updateData()
    {
        include_once "Database.php";
        
        Database::safeStart();
        
        $stmt = Database::$mysqli->stmt_init();
        $query = "UPDATE users SET"
                ." name=?,"
                ." last_name=?,"
                ." address=?"
                ." WHERE id=?";
        $stmt->prepare($query);
        echo $stmt->error;
        $stmt->bind_param("ssss",
                $this->name, $this->last_name, $this->address, $this->id);
        $stmt->execute();
        
    }

    public function __toString()
    {
        $string = "UID: $this->id<br/>\n".
                "  username = $this->username<br/>\n".
                "  password = $this->password<br/>\n".
                "  name = $this->name<br/>\n".
                "  lastname = $this->last_name<br/>\n".
                "  address = $this->address<br/>\n";
        
        return $string;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getName() {
        return $this->name;
    }

    public function getLast_name() {
        return $this->last_name;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setLast_name($last_name) {
        $this->last_name = $last_name;
    }

    public function setAddress($address) {
        $this->address = $address;
    }


}
