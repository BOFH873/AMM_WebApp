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

require_once __DIR__."/default.php";
require_once __DIR__."/../model/User.php";


switch ($_REQUEST["page"])
{
    case "login":
        if (!isset($_SESSION["id"]))
        {
            if (isset($_REQUEST["user"]) && isset($_REQUEST["pass"]))
            {
                $user = User::getUserByUsername($_REQUEST["user"]);
                if ($user && $user->getPassword() == $_REQUEST["pass"])
                {
                    $_SESSION = array();
                    $_SESSION["user"] = $user->getUsername();
                    $_SESSION["id"] = $user->getId();
                }
                else
                {
                    $vd->setErrorMsg("Wrong User/Pass specified!");
                }
            }
            else
            {
                $vd->setErrorMsg("No User/Pass specified!");
            }
        }
        else
        {
            $vd->setErrorMsg("You are already logged in! Please log out before"
                    ." trying to log in.");
        }
        break;
        
    case "logout":
        if (isset($_SESSION["id"]))
        {
            setcookie(session_name(), "", time() - 42000);
            $_SESSION = array();
            session_destroy();
        }
        else
        {
            $vd->setErrorMsg("You are not logged in!");
        }
        break;
    
    default:
}
