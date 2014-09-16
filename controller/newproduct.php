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

function isNewProductForm()
{
    if (isset($_REQUEST["pname"]) &&
        isset($_REQUEST["qty"]) &&
        isset($_REQUEST["category"]) &&
        isset($_REQUEST["price"]) &&
        isset($_REQUEST["description"]))
    {
        return true;
    }
    else
    {
        return false;
    }    
}

function checkInput()
{
    $opt_min_qty = array("options" =>
        array("min_range" => 0));
    $opt_min_pcat = array("options" =>
        array("min_range" => 1));
    
    
    $pname = filter_var($_REQUEST["pname"],
            FILTER_SANITIZE_STRING,
            FILTER_FLAG_STRIP_HIGH |
            FILTER_FLAG_STRIP_LOW);
    if (!$pname) {return "Product name invalid!</br>\n";}    
    $_REQUEST["pname"] = $pname;
    
    $qty = filter_var($_REQUEST["qty"],
            FILTER_VALIDATE_INT,
            $opt_min_qty);
    if (!$qty) {return "Quantity invalid!</br>\n";}    
    
    $pcategory = filter_var($_REQUEST["category"],
            FILTER_VALIDATE_INT,
            $opt_min_pcat);
    if (!$pcategory) {return "Category invalid!</br>\n";}   
    
    global $categoriesArray;
    $cat_exists = false;
    foreach ($categoriesArray as $cat)
    {
        if ($cat->getId() == $pcategory
                && !count($cat->getChildren()))
        {
            $cat_exists = true;
            break;
        }
    }
    if (!$cat_exists) {return "Category does not exist!</br>\n";}
    
    $price = filter_var($_REQUEST["price"],
            FILTER_VALIDATE_FLOAT);
    if (!$price) {return "Price invalid!</br>\n";}   
            
    $description = filter_var($_REQUEST["description"],
            FILTER_SANITIZE_STRING,
            FILTER_FLAG_STRIP_HIGH);
    if (!$description) {return "Description invalid!</br>\n";}    
    $_REQUEST["description"] = $description;
                        
    return "";
}
function checkPic()
{
    if ($_FILES["pic"]["error"] > 0)
    {
        return "Error (". $_FILES["pic"]["error"] .") while uploading"
                . " picture!<br/>\n";
    }

    if (($_FILES["pic"]["type"] != "image/jpeg") &&
            ($_FILES["pic"]["type"] != "image/jpg") &&
            ($_FILES["pic"]["type"] != "image/pjpeg") &&
            ($_FILES["pic"]["type"] != "image/x-png") &&
            ($_FILES["pic"]["type"] != "image/png"))
    {
        var_dump($_FILES["pic"]["type"]);
        exit();
        return "Invalid picture format! (allowed: jpeg,png)<br/>\n";
    }

    if ($_FILES["pic"]["size"] > 1024*512)

    {
        return "Picture must be &lt; 512KB!<br/>\n";
    }
    
    $size = getimagesize($_FILES["pic"]["tmp_name"]);
    
    if (($size[0] < 150)
            || ($size[1] < 100))
    {
        return "Picture resolution too low! (min: 150x100)<br/>\n";
    }
    
    return "";
}

if (isset($_SESSION["id"]))
{
    require_once __DIR__."/../view/ViewDescriptor.php";
    require_once __DIR__."/../model/Category.php";
    require_once __DIR__."/../model/Product.php";

    $vd = new ViewDescriptor();
    $vd->setContentFile(__DIR__."/../view/newproduct/contentFile.php");

    $categories = Category::getCategories();
    $categoriesArray = Category::getCategoriesArray();
   
    $errorMsg = "";
    
    if (isNewProductForm())
    {
        $errorMsg .= checkInput();
        
        if (isset($_FILES["pic"]))
        {
            $errorMsg .= checkPic();
        }
        
        if ($errorMsg == "")
        {            
            $data = new stdClass();
            
            $data->id = -1;
            $data->name = $_REQUEST["pname"];
            $data->stock_qty = $_REQUEST["qty"];
            $data->category_id = $_REQUEST["category"];
            $data->price = $_REQUEST["price"];
            $data->description = $_REQUEST["description"];
            
            if (isset($_FILES["pic"]))
            {
                $data->picture = $_FILES["pic"]["tmp_name"];
                $data->mimetype = $_FILES["pic"]["type"];
            }
                    
            Product::uploadNewProduct($data);
            
        }
        
    $vd->setErrorMsg($errorMsg);
    }
}
else
{
    require_once __DIR__."/default.php";
    $vd->setErrorMsg("You are not logged in!");
}