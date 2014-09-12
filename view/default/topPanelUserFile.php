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

if (isset($_SESSION["id"]))
{
    ?>
    <form id="logged-in">
        Welcome, <strong><?=$_SESSION["user"]?></strong>
        <input id="logout-button" type="submit"
               formaction="<?=$appPath?>/logout"
               formmethod="post" value="Log out">
    </form>
    <?php
}
else
{
    ?>
    <form id="login-form">
        <label id="user-label" for="login-user">User:</label>
        <input id="login-user" type="text" value="Username" name="user">
        <label id="pass-label" for="login-pass">Password:</label>
        <input id="login-pass" type="password" value="Password" name="pass">
        <input id="login-button" type="submit"
               formaction="<?=$appPath?>/login"
               formmethod="post" value="Sign in">
    </form>
    <?php
}