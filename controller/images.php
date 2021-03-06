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

require_once __DIR__."/../Database.php";
require_once __DIR__."/../model/Product.php";

switch ($_REQUEST["type"]) {

    case "product":
        
        $result = Product::getProductByID($_REQUEST["id"]);
        
        if (!$result)
        {
            header('HTTP/1.0 404 Not Found');
            exit();
        }
        
        header('Pragma: public');
        header('Cache-Control: max-age=86400');
        header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
        header('Content-Type: image/png');        $pic = $result->getPicture();

        if ($pic != null)
        {
            header("Content-type: " . $result->getMimeType());
            echo $result->getPicture();
        }
        else
        {
            header("Content-type: image/png");
            readfile(__DIR__."/../images/noimage.png");
        }

        break;
    
    default:
        header('HTTP/1.0 404 Not Found');
        exit();
        break;
    
}