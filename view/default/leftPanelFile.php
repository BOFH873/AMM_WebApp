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

function printCatArray($catArray)
{
    $string = "<ul class=\"collapsible\">\n";
    foreach ($catArray as $category)
    {
        $string .= printCat($category);
    }
    $string .= "</ul>\n";
    
    return $string;
}

function printCat($cat)
{
        $string = "<li>\n";

        $labelString = "<label for=\"cat".$cat->getId()."\">\n";
        $labelString .= $cat->getName()."\n";
        $labelString .= "</label>\n";
        
        if (count($cat->getChildren()))
        {
            $string .= "<input id=\"cat".$cat->getId()."\" type=\"checkbox\""
                    . "checked>\n";
            $string .= $labelString;
            $string .= printCatArray($cat->getChildren());
        }
        else
        {
            $string .= $labelString;
        }

        $string .= "</li>\n";
        
        return $string;
}

?>

<h4 id="categories-list-title">Categories</h4>
<?= printCatArray($categories) ?>