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

<form id="newproduct-form" class="contentform">
    <p>
        <label for="pname-field">Name: </label><input
            id="pname-field"
            type="text"
            name="pname">
    </p>
    <p>
        <label for="qty-field">Qty: </label><input
            id="qty-field"
            type="text"
            name="qty">
    </p>
    <p>
        <label for="category-field">Category: </label><input
            id="category-field"
            type="text"
            name="category">
    </p>
    <p>
        <label for="price-field">Price: </label><input
            id="price-field"
            type="text"
            name="price">
    </p>
    <p>
        <label for="description-field">Description: </label><input
            id="description-field"
            type="text"
            name="description">
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
                value="Create product">
    </p>
</form>