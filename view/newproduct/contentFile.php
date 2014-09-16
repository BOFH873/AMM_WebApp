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

function printCatTree($catTree)
{
    foreach($catTree as $cat)
    {
        $children = $cat->getChildren();
        if (count($children))
        {
            echo "<optgroup label=\"". $cat->getName() ."\">\n";
            printCatTree($children);
            echo "</optgroup>\n";
        }
        else
        {
            echo "<option value=\""
                    .$cat->getId() 
                    ."\">"
                    .$cat->getName()
                    ."</option>\n";
        }
    }
}

?>

<form id="newproduct-form" class="contentform" enctype="multipart/form-data" method="POST">
    <p>
        <label for="pname-field">Name: </label><input
            id="pname-field"
            type="text"
            name="pname">
    </p>
    <p>
        <label for="qty-field">Qty: </label><input
            id="qty-field"
            type="number"
            min="0"
            value="0"
            name="qty">
    </p>
    <p>
        <label for="category-field">Category: </label><select
            id="category-field"
            type="text"
            name="category">
            <?=printCatTree($categories)?>
        </select>
    </p>
    <p>
        <label for="price-field">Price: </label><input
            id="price-field"
            type="text"
            name="price">
    </p>
    <p>
        <label for="description-field">Description: </label><textarea
            id="description-field"
            type="text"
            name="description"
            rows="5">
        </textarea>
    </p>
    <p>
        <label for="pic-field">Picture: </label><input
            id="pic-field"
            type="file"
            name="pic">
    </p>
    <p class="submit-paragraph">
        <input id="prod-submit"
                type="submit"
                formaction="<?=$appPath?>/newproduct"
                formmethod="POST"
                formenctype="multipart/form-data"
                value="Create product">
    </p>
</form>