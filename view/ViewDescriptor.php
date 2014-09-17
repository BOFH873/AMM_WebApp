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

/**
 * ViewDescriptor contiene le informazioni necessarie per la generazione delle
 * singole parti della pagina.
 *
 * @author BOFH873
 */
class ViewDescriptor {
    
    /**
     * @var string Stringa contenente il titolo della pagina. 
     */
    private $title;
    
    /**
     * @var array Array di stringhe che puntano ai file contenenti il codice
     *            JavaScript da caricare nella pagina.
     */
    private $scripts;
    
    /**
     * @var string Stringa contenente il nome del file col codice dell'header.
     */
    private $headerFile;

    /**
     * @var string Stringa contenente il nome del file col codice del pannello
     *             di navigazione in cima.
     */
    private $topPanelNavFile;

    /**
     * @var string Stringa contenente il nome del file col codice del pannello
     *             utente (in cima).
     */
    private $topPanelUserFile;
    
    /**
     * @var string Stringa contenente il nome del file col codice del pannello
     *             laterale di sinistra.
     */
    private $leftPanelFile;
    
    /**
     * @var string Stringa contenente il nome del file col codice del contenuto
     *             principale della pagina.
     */
    private $contentFile;

    /**
     * @var string Stringa contenente il nome del file col codice del footer.
     */
    private $footerFile;
    
    /**
     * @var string Stringa contenente un messaggio di errore da visualizzare
     *             nel footer.
     */
    private $errorMsg;
    
    public function __construct()
    {
        global $appPath;
        
        $this->title = "AMM_WebApp";
        $this->scripts = array();
        $this->headerFile = __DIR__."/default/headerFile.php";
        $this->topPanelNavFile = __DIR__."/default/topPanelNavFile.php";
        $this->topPanelUserFile = __DIR__."/default/topPanelUserFile.php";
        $this->leftPanelFile = __DIR__."/default/leftPanelFile.php";
        $this->contentFile = __DIR__."/default/contentFile.php";
        $this->footerFile = __DIR__."/default/footerFile.php";
    }
    
    
    /**
     *  Vari Getter e Setter per le variabili private.
     */
    
    public function getTitle() {
        return $this->title;
    }

    public function getScripts() {
        return $this->scripts;
    }

    public function getHeaderFile() {
        return $this->headerFile;
    }

    public function getTopPanelNavFile() {
        return $this->topPanelNavFile;
    }

    public function getTopPanelUserFile() {
        return $this->topPanelUserFile;
    }

    public function getLeftPanelFile() {
        return $this->leftPanelFile;
    }

    public function getContentFile() {
        return $this->contentFile;
    }

    public function getFooterFile() {
        return $this->footerFile;
    }

    public function getErrorMsg() {
        return $this->errorMsg;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }

    public function setScripts($scripts) {
        $this->scripts = $scripts;
    }

    public function setHeaderFile($headerFile) {
        $this->headerFile = $headerFile;
    }

    public function setTopPanelNavFile($topPanelNavFile) {
        $this->topPanelNavFile = $topPanelNavFile;
    }

    public function setTopPanelUserFile($topPanelUserFile) {
        $this->topPanelUserFile = $topPanelUserFile;
    }

    public function setLeftPanelFile($leftPanelFile) {
        $this->leftPanelFile = $leftPanelFile;
    }

    public function setContentFile($contentFile) {
        $this->contentFile = $contentFile;
    }

    public function setFooterFile($footerFile) {
        $this->footerFile = $footerFile;
    }

    public function setErrorMsg($errorMsg) {
        $this->errorMsg = $errorMsg;
    }
}
