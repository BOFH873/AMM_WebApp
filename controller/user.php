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

function isUserForm()
{
    if (isset($_REQUEST["old-pass"]) &&
        isset($_REQUEST["new-pass"]) &&
        isset($_REQUEST["repeat-pass"]) &&
        isset($_REQUEST["name"]) &&
        isset($_REQUEST["lastname"]) &&
        isset($_REQUEST["address"]))
    {
        return true;
    }
    else
    {
        return false;
    }    
}

function checkPass()
{
    if ($_REQUEST["old-pass"] == "" &&
            $_REQUEST["new-pass"] == "" &&
            $_REQUEST["repeat-pass"] == "")
    {
        return "";
    }
    
    $options = array("options" => array("regexp" => "/[0-9A-Za-z!@#$%_]{8,}/"));
    
    $new_pass = filter_var($_REQUEST["new-pass"],
            FILTER_VALIDATE_REGEXP,
            $options);
    
    if ($new_pass)
    {
        if ($new_pass != $_REQUEST["repeat-pass"])
        {
            return "New password/Confirm password mismatch!<br/>\n";
        }
    }
    else
    {
        return "New password invalid!" .
                " Password may contain 0-9A-Za-z!@#$%_ and" .
                " must be at least 8 characters long!<br/>\n";
    }
    
    $old_pass = filter_var($_REQUEST["old-pass"],
            FILTER_VALIDATE_REGEXP,
            $options);
    
    
    global $user;
    
    if ($old_pass != $user->getPassword())
    {
        return "Old password doesn't match!<br/>\n";
    }
    
    return "";
    
}

function checkInfo()
{
    return "";
}

function submitData()
{
    
}

if (isset($_SESSION["id"]))
{
    require_once __DIR__."/../view/ViewDescriptor.php";
    require_once __DIR__."/../model/Category.php";
    require_once __DIR__."/../model/User.php";

    $vd = new ViewDescriptor();
    $vd->setContentFile(__DIR__."/../view/user/contentFile.php");

    $categories = Category::getCategories();
    $categoriesArray = Category::getCategoriesArray();
    
    $user = User::getUserByUsername($_SESSION["user"]);
    
    $errorMsg = "";

    if (isUserForm())
    {
        $errorMsg .= checkPass();
        $errorMsg .= checkInfo();
        
        if ($errorMsg == "")
        {
            $errorMsg = "Everything's fine! :D";
//            submitData();
//            $user = User::getUserByUsername($_SESSION["user"]);    
        }
    }    

    $vd->setErrorMsg($errorMsg);
}
else
{
    require_once __DIR__."/default.php";
    $vd->setErrorMsg("You are not logged in!");
}