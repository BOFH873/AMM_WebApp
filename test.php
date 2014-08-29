<!DOCTYPE html>
<!--
Copyright (C) 2014 BOFH873

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>Testestest!</title>
    </head>
    <body>
        <p>
            <h2>User test:</h2>
            <?php        
                include_once __DIR__."/model/User.php";
                $users = User::getUsers();
                foreach ($users as $user)
                {
                    echo "$user";
                }
            ?>
        </p>
        <p>
            <h2>Category test:</h2>
            <?php   
                include_once __DIR__."/model/Category.php";
                
                echo Category::printArray(Category::getCategories());
            ?>
        </p>
        <p>
            <h2>Redirect test:</h2>
            <?php if (isset($_REQUEST["page"])) { ?>
                page: <?= $_REQUEST["page"] ?>
            <?php } else { ?>
                page UNSET
            <?php } ?>
        </p>
        <p>
            <h2>Sample test:</h2>
        </p>
    </body>        

</html>
