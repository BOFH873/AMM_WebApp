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


function printCatOptions($catTree, $categoriesArray)
{
    $return_string = "";
    
    foreach ($catTree as $cat)
    {

        $return_string .= "<option value=\""
                .$cat->getId() 
                ."\">"
                . Category::catHierarchyString($categoriesArray, $cat)
                ."</option>\n";
        
        $children = $cat->getChildren();
        if (count($children))
        {
            $return_string .= printCatOptions($children, $categoriesArray);
        }
    }
    
    return $return_string;
}


?>

<div id="categories-edit">
<form id="newcat-form" class="contentform">
    <p>
        <label for="cname-field">New category name: </label><input
            id="cname-field"
            type="text"
            name="cname">
    </p>
    <p>
        <label for="pcat-field">Parent category: </label><select
            id="pcat-field"
            type="text"
            name="parentcat">
            <option value="1">Root Category</option>
            <?=  printCatOptions($categories, $categoriesArray) ?>
        </select>
    </p>
    <p class="submit-paragraph">
        <input id="newcat-submit"
                type="submit"
                formaction="<?=$appPath?>/editcat"
                formmethod="POST"
                value="Create Category"
                name="newcat">
    </p>
</form>

<form id="editcat-form" class="contentform">
    <p>
        <label for="ecat-field">Edit category: </label><select
            id="ecat-field"
            type="text"
            name="ecat">
            <?=  printCatOptions($categories, $categoriesArray) ?>
        </select>
    </p>
    <p>
        <label for="ecname-field">New category name: </label><input
            id="ecname-field"
            type="text"
            name="ecname">
    </p>
    <p>
        <label for="epcat-field">New parent category: </label><select
            id="epcat-field"
            type="text"
            name="epcat">
            <option value="1">Root Category</option>
            <?=  printCatOptions($categories, $categoriesArray) ?>
        </select>
    </p>
    <p class="submit-paragraph">
        <input id="editcat-submit"
                type="submit"
                formaction="<?=$appPath?>/editcat"
                formmethod="POST"
                value="Edit Category"
                name="editcat">
    </p>
</form>

<form id="delcat-form" class="contentform">
    <p>
        <label for="dcat-field">Delete category: </label><select
            id="dcat-field"
            type="text"
            name="dcat">
            <?=  printCatOptions($categories, $categoriesArray) ?>
        </select>
    </p>
    <p class="submit-paragraph">
        Warning, this will delete all child categories and products belonging to
        this category.<br/>
        <input id="cat-submit"
                type="submit"
                formaction="<?=$appPath?>/editcat"
                formmethod="POST"
                value="Delete Category"
                name="delcat">
    </p>
</form>
</div>