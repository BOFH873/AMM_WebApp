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

require_once __DIR__."/../model/Category.php";
require_once __DIR__."/../model/Product.php";

$categories = Category::getCategories();

$products = Product::getProducts();
$categoriesArray = Category::getCategoriesArray();

if (isset($_REQUEST["type"]))
{
    switch ($_REQUEST["type"])
    {
        case "products":

            global $products;
            
            if (!isset($_REQUEST["id"])) {break;}

            $opt_min_cat = array("options" =>
                array("min_range" => 1));

            $cat_id = filter_var($_REQUEST["id"],
                    FILTER_VALIDATE_INT,
                    $opt_min_cat);
            
            if (!$cat_id) {break;}   

            $cat_exists = false;
            foreach ($categoriesArray as $cat)
            {
                if ($cat->getId() == $cat_id)
                {
                    $cat_exists = true;
                    break;
                }
            }
            if (!$cat_exists) {break;}
                        
            $category = new stdClass();
            $category->id = $_REQUEST["id"];
            $category->children
                    = Category::getCategories($_REQUEST["id"]);  
                
            $products = Product::getProductByCat($category);
            
            require_once __DIR__."/../view/default/contentFile.php";
            exit();
            
            break;
            
        default:
            break;
    }
}

header('HTTP/1.0 404 Not Found');
exit();