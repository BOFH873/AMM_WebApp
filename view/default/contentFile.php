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
?>

<ul id="products-list">

    <?php
    
    $maxvisible = 9;
    
    shuffle($products);
    
    for($i=0;$i < count($products); $i++)
    {
        $string = "<li";
        if ($i >= $maxvisible) { $string .= " class=\"invisible\""; }
        $string .= ">\n";
        
        $string .= "<div class=\"image-container\"><img src=\""
                .$appPath
                ."/images/product/"
                .$products[$i]->getId()
                . "\""
                ." alt=\""
                .$products[$i]->getName()
                ." IMAGE\" class=\"product-image\"></div>\n";
        $string .= "<p class=\"product-name\">".$products[$i]->getName()."</p>\n";
        
        foreach($categoriesArray as $category)
        {
            if ($category->getId() == $products[$i]->getCategory_id())
            {
                $catName = Category::catHierarchyString($categoriesArray,
                        $category);
                break;
            }
        }
        
        $string .= "<p class=\"product-category\">$catName</p>\n";
        
        $string .= "</li>";
    
        echo $string;
    }
    
    
    ?>
</ul>