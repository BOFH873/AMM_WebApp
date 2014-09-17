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

function seekCategory($id, $catTree)        
{
    if (!is_array($catTree))
    {
        return false;
    }
    
    foreach($catTree as $cat)
    {
        if ($cat->getId() == $id)
        {
            return true;
        }
        if (seekCategory($id, $cat->getChildren()))
        {
            return true;
        }
    }
    return false;
    
}

function checkNewCat()
{
    $cat_regexp = array("options" =>
        array("regexp" => "/^[A-Za-z0-9\/\\,]+( [A-Za-z0-9\/\\,]+)*$/"));
    
    $opt_min_cat = array("options" =>
        array("min_range" => 1));

    $cname = filter_var($_REQUEST["cname"],
            FILTER_VALIDATE_REGEXP,
            $cat_regexp);
    if (!$cname) {return "Name invalid!</br>\n";}    
    
    $parentcat = filter_var($_REQUEST["parentcat"],
            FILTER_VALIDATE_INT,
            $opt_min_cat);
    if (!$parentcat) {return "Parent Category invalid!</br>\n";}   

    global $categoriesArray;
    $cat_exists = false;
    foreach ($categoriesArray as $cat)
    {
        if ($cat->getId() == $parentcat)
        {
            $cat_exists = true;
            break;
        }
    }
    if (!$cat_exists) {return "Parent Category does not exist!</br>\n";}
}

function checkEditCat()
{
    $cat_regexp = array("options" =>
        array("regexp" => "/^[A-Za-z0-9\/\\,]+( [A-Za-z0-9\/\\,]+)*$/"));
    
    $opt_min_cat = array("options" =>
        array("min_range" => 1));
    
    // TEST EDITING CATEGORY
    
    $ecat = filter_var($_REQUEST["ecat"],
            FILTER_VALIDATE_INT,
            $opt_min_cat);
    if (!$ecat) {return "Edit Category invalid!</br>\n";}   

    global $categoriesArray;
    $cat_exists = false;
    foreach ($categoriesArray as $cat)
    {
        if ($cat->getId() == $ecat && $cat->getId() != 1)
        {
            $cat_exists = true;
            break;
        }
    }
    if (!$cat_exists) {return "Edit Category does not exist!</br>\n";}

    // TEST NEW CATEGORY NAME

    $ecname = filter_var($_REQUEST["ecname"],
            FILTER_VALIDATE_REGEXP,
            $cat_regexp);
    if (!$ecname) {return "Name invalid!</br>\n";}    
    
    
    // TEST NEW PARENT CATEGORY

    $epcat = filter_var($_REQUEST["epcat"],
            FILTER_VALIDATE_INT,
            $opt_min_cat);
    if (!$epcat) {return "New Parent Category invalid!</br>\n";}   

    global $categoriesArray;
    $cat_exists = false;
    foreach ($categoriesArray as $cat)
    {
        if ($cat->getId() == $epcat)
        {
            $cat_exists = true;
            break;
        }
    }
    if (!$cat_exists) {return "New Parent Category does not exist!</br>\n";}
    
    $ecatTree = Category::getCategories($ecat);
    $cat_recursion = seekCategory($epcat, $ecatTree);
    if ($epcat == $ecat || $cat_recursion)
    {
        return "Category recursion detected!<br/>\n";
    }
}

function checkDelCat()
{
    $opt_min_cat = array("options" =>
        array("min_range" => 1));

    $dcat = filter_var($_REQUEST["dcat"],
            FILTER_VALIDATE_INT,
            $opt_min_cat);
    if (!$dcat) {return "Delete Category invalid!</br>\n";}   

    global $categoriesArray;
    $cat_exists = false;
    foreach ($categoriesArray as $cat)
    {
        if ($cat->getId() == $dcat)
        {
            $cat_exists = true;
            break;
        }
    }
    if (!$cat_exists) {return "Delete Category does not exist!</br>\n";}
    
    if ($dcat == 1) {return "Cannot delete root category!</br>\n";}
}

if (isset($_SESSION["id"])
        && isset($_SESSION["user"])
        && $_SESSION["user"] == "admin")
{
    require_once __DIR__."/../view/ViewDescriptor.php";
    require_once __DIR__."/../model/Category.php";

    $vd = new ViewDescriptor();
    $vd->setContentFile(__DIR__."/../view/editcat/contentFile.php");

    $categories = Category::getCategories();
    $categoriesArray = Category::getCategoriesArray();
   
    $errorMsg = "";
    
    if (isset($_REQUEST["newcat"]))
    {
        $errorMsg .= checkNewCat();
        
        if ($errorMsg == "")
        {            
            $newCategory = new stdClass();
            $newCategory->name = $_REQUEST["cname"];
            $newCategory->parent_id = $_REQUEST["parentcat"];
            Category::createCategory($newCategory);
        }
        
    }
    elseif (isset($_REQUEST["editcat"]))
    {
        $errorMsg .= checkEditCat();
        
        if ($errorMsg == "")
        {
            $editCategory = new stdClass();
            $editCategory->name = $_REQUEST["ecname"];
            $editCategory->parent_id = $_REQUEST["epcat"];
            $editCategory->id = $_REQUEST["ecat"];
            
            Category::updateCategory($editCategory);
        }
    }
    elseif (isset($_REQUEST["delcat"]))
    {
        require_once __DIR__."/../model/Product.php";
        
        $errorMsg .= checkDelCat();
        
        if ($errorMsg == "")
        {
            $delCategory = new stdClass();
            $delCategory->id = $_REQUEST["dcat"];
            $delCategory->children
                    = Category::getCategories($_REQUEST["dcat"]);  
            
            Database::startTransaction();
            Product::deleteProductsFromCategory($delCategory);
            Category::deleteCatAndChildren($delCategory);
            Database::commit();
        }
    }
    
    $vd->setErrorMsg($errorMsg);
}
else
{
    require_once __DIR__."/default.php";
    $vd->setErrorMsg("You don't have admin privileges!");
}