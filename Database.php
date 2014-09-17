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
 * Parametri per la configurazione del database.
 */

const db_host = "localhost"; // Indirizzo del db

const db_user_local = "amm_webapp"; // Nome utente per il db locale
const db_user_remote = "salarisDavide"; // Nome utente per il db remoto

const db_password_local = "ppabew_mma"; // Password per il db locale
const db_password_remote = "locusta677"; // Password per il db remoto

const db_name_local = "amm_webapp"; // Nome del db locale
const db_name_remote = "amm14_salarisDavide"; // Nome del db remoto

const db_port = "3306"; // Porta del db

global $db_backup_file;
$db_backup_file = __DIR__ . "/amm_webapp.sql";
/**
 * Implementazione comunicazione col database, NON MODIFICARE DA QUI IN POI.
 */

global $db_user_var;
global $db_password_var;
global $db_name_var;

switch ($_SERVER['HTTP_HOST']) {
    case 'localhost':
        $db_user_var = db_user_local;
        $db_password_var = db_password_local;
        $db_name_var = db_name_local;
        break;
    case 'spano.sc.unica.it':
        $db_user_var = db_user_remote;
        $db_password_var = db_password_remote;
        $db_name_var = db_name_remote;
        break;
}


/**
 * Description of Database
 *
 * @author BOFH873
 */
abstract class Database {
    
    // Contenitore oggetto mysqli
    public static $mysqli;
    
    // Flag per transazioni
    private static $transaction = false;
        
    /**
     * Metodo da invocare per l'inizializzazione dell'oggetto mysqli e della
     * connessione.
     * 
     * @return int|null Restituisce il codice di errore associato al tentativo
     *                   di connessione col db.
     */
    public static function safeStart()
    {
        if (!self::$mysqli)
        {
            
            global $db_user_var;
            global $db_password_var;
            global $db_name_var;
                        
            self::$mysqli = new mysqli(
                    db_host,
                    $db_user_var,
                    $db_password_var,
                    $db_name_var);
        }
        
        return self::$mysqli->connect_errno;
    }    
    
    public static function startTransaction()
    {
        self::safeStart();
        if (!self::$transaction)
        {
            self::$transaction = true;
            self::$mysqli->query("START TRANSACTION;");
        }
    }
    
    public static function commit()
    {
        self::safeStart();
        if (self::$transaction)
        {
            self::$transaction = false;
            self::$mysqli->query("COMMIT;");
        }
    }
    
    public static function restoreDB()
    {
        global $db_backup_file;
        
        self::safeStart();
        
        $templine = "";
        // Apertura file di backup
        $lines = file($db_backup_file);

        // Parsing di tutte le linee
        foreach ($lines as $line)
        {
            // Salta i commenti
            if (substr($line, 0, 2) == '--' || $line == '')
            {
                continue;
            }
            
            // Aggiunge il segmento attuale alla query finale
            $templine .= $line;
            // Se c'è un ; alla fine eseguo la query
            if (substr(trim($line), -1, 1) == ';')
            {
                // Eseguo
                self::$mysqli->query($templine);
                // Libero $templine
                $templine = '';
            }        
        }
    }
}
