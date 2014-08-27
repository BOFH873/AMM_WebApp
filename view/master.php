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
        <title id="title"><?= $vd->getTitle() ?></title>

        <meta name="description" content="Applicazione web e-commerce per 
              progetto Amministrazione di Sistema">
        <meta name="keywords" content="AMM e-commerce informatica">
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        
        <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
        <link href="../css/style.css" rel="stylesheet" type="text/css" 
              media="screen">
        <?php
            foreach ($vd->getScripts() as $script) {
        ?>
        <script type="text/javascript" src="<?= $script ?>"></script>
        <?php
            }
        ?>

    </head>
    <body>
        <div id="page">
            <header id="header">
                <?php
                    $headerFile = $vd->getHeaderFile();
                    require $headerFile;
                ?>
            </header>
            <div id="top-panel">
                <nav id="top-panel-nav">
                <?php
                    $topPanelNavFile = $vd->getTopPanelNavFile();
                    require $topPanelNavFile;
                ?>
                </nav>
                <div id="top-panel-user">
                <?php
                    $topPanelUserFile = $vd->getTopPanelUserFile();
                    require $topPanelUserFile;
                ?>
                </div>
            </div>
            <div id="left-panel">
                <?php
                    $leftPanelFile = $vd->getLeftPanelFile();
                    require $leftPanelFile;
                ?>
            </div>
            <div id="content">
                <?php
                    $contentFile = $vd->getContentFile();
                    require $contentFile;
                ?>
            </div>
            <footer id="footer">
                <?php
                    $footerFile = $vd->getFooterFile();
                    require $footerFile;
                ?>
            </footer>
        </div>
    </body>
</html>
