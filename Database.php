<?php

/*
 * Copyright (C) 2014 drgb
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
 * Parametri per la configurazione del database.
 */

const db_host = "localhost"; // Indirizzo del db

const db_user = "amm_webapp"; // Nome utente per il db

const db_password = "ppabew_mma"; // Password per il db

const db_name = "amm_webapp"; // Nome del db

const db_port = "3306"; // Porta del db


/**
 * Implementazione comunicazione col database, NON MODIFICARE DA QUI IN POI.
 */

/**
 * Description of Database
 *
 * @author drgb
 */
abstract class Database {
    
    // Contenitore oggetto mysqli
    public static $mysqli;
        
    /**
     * Metodo da invocare per l'inizializzazione dell'oggetto mysqli e della
     * connessione.
     * 
     * @return int|null Restituisce il codice di errore associato al tentativo
     *                   di connessione col db.
     */
    public static function safeStart()
    {
        if (!$this->mysqli)
        {
            $this->mysqli = new mysqli(
                    db_host,
                    db_user,
                    db_password,
                    db_name);
        }
        
        return $this->mysqli->connect_errno;
    }    
    
}
