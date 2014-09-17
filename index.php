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
 *  VARIABILI DI CONFIGURAZIONE
 */

/**
 *  Directory in cui si trova questo file (a partire dalla DocumentRoot).
 * 
 *  Esempio: DocumentRoot = "/srv/httpd/"
 *           Percorso index.php = "/srv/httpd/AMM_WebApp/index.php"
 * 
 *           $appPath -----------> "/AMM_WebApp"
 */
$appPath_local = "/AMM_WebApp";
$appPath_remote = "/amm2014/salarisDavide";

switch ($_SERVER['HTTP_HOST']) {
    case 'localhost':
        $appPath = $appPath_local;
        break;
    case 'spano.sc.unica.it':
        $appPath = $appPath_remote;
        break;
}

/**
 *  FINE VARIABILI DI CONFIGURAZIONE
 */

require_once __DIR__."/view/ViewDescriptor.php";

date_default_timezone_set("Europe/Rome");

session_name("AMM_WebApp");
session_start();

switch ($_REQUEST["page"]) {

    case "user":
        require_once __DIR__."/controller/user.php";
        require_once __DIR__."/view/master.php";
        break;
    
    case "newproduct":
        require_once __DIR__."/controller/newproduct.php";
        require_once __DIR__."/view/master.php";
        break;
    
    case "resetdb":
        require_once __DIR__."/controller/resetdb.php";
        require_once __DIR__."/view/master.php";
        break;
    
    case "editcat":
        require_once __DIR__."/controller/editcat.php";
        require_once __DIR__."/view/master.php";
        break;

    case "logout":        
    case "login":
        require_once __DIR__."/controller/login.php";
        require_once __DIR__."/view/master.php";
        break;
            
    default:
        require_once __DIR__."/controller/default.php";
        require_once __DIR__."/view/master.php";
        break;
    
}