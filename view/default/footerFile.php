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

<?php
    if ($vd->getErrorMsg())
    {
?>

<p id="error-text"><?=$vd->getErrorMsg()?></p>

<?php
    }
?>
<p id="footer-text">
    Progetto realizzato interamente con NetBeans.<br/>
    Autore: Davide Salaris<br/>
</p>
<div id="validators">
<a href="http://validator.w3.org/check/referer"
   id="xhtml-validator">
    <abbr title="eXtensible HyperText Markup Language">HTML</abbr>
    Valid
</a>
<a href="http://jigsaw.w3.org/css-validator/check/referer"
   id="css-validator">
    <abbr title="Cascading Style Sheets">CSS</abbr>
    Valid
</a>
</div>