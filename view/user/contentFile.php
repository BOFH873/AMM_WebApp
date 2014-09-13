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

<form id="profile-form">
    <p>
        <label for="user-field">User: </label><input
            id="user-field"
            type="text"
            disabled="true"
            value="<?=$user->getUsername()?>">
    </p>
    <p>
        <label for="old-pass-field">Old Password: </label><input
            id="old-pass-field"
            type="password"
            name="old-pass">
    </p>
    <p>
        <label for="new-pass-field">New Password: </label><input
            id="new-pass-field"
            type="password"
            name="new-pass">
    </p>
    <p>
        <label for="repeat-pass-field">Repeat Password: </label><input
            id="repeat-pass-field"
            type="password"
            name="repeat-pass">
    </p>
    <p>
        <label for="name-field">Name: </label><input
            id="name-field"
            type="text"
            name="name"
            value="<?=$user->getName()?>">
    </p>
    <p>
        <label for="lastname-field">Lastname: </label><input
            id="lastname-field"
            type="text"
            name="lastname"
            value="<?=$user->getLast_Name()?>">
    </p>
    <p>
        <label for="address-field">Address: </label><input
            id="address-field"
            type="text"
            name="address"
            value="<?=$user->getAddress()?>">
    </p>
    <p id="submit-paragraph">
        <input id="user-submit"
                type="submit"
                formaction="<?=$appPath?>/user"
                formmethod="POST"
                value="Submit data">
    </p>
</form>