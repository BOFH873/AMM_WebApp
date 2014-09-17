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

if (isset($_SESSION["id"])
        && isset($_SESSION["user"])
        && $_SESSION["user"] == "admin")
{
    require_once __DIR__."/../view/ViewDescriptor.php";
    require_once __DIR__."/../model/Category.php";

    $vd = new ViewDescriptor();
    $vd->setContentFile(__DIR__."/../view/resetdb/contentFile.php");
        
    $categories = Category::getCategories();
    $categoriesArray = Category::getCategoriesArray();
    
    $errorMsg = "";
    
    if (isset($_REQUEST["resetdb"]))
    {
        require_once __DIR__."/../Database.php";        
        Database::restoreDB();
        $errorMsg .= "Database Reset!<br/>\n";
    }
    
    $vd->setErrorMsg($errorMsg);
}
else
{
    require_once __DIR__."/default.php";
    $vd->setErrorMsg("You don't have admin privileges!");
}