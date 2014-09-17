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

<div id="info">
    <p class="main-title overline">AMM_WebApp</p>
    <p class="sub-title overline">Introduzione</p>
    <p class="info-text">
        AMM_WebApp è un portale di e-commerce dedicato al mondo
        dell'IT.<br/>
        Nella homepage è possibile visualizzare una lista che mostra alcuni dei
        prodotti in vendita (per ragioni di fruibilità il limite di prodotti
        visualizzabili è stato impostato a 9).
        I prodotti mostrati nella home vengono scelti casualmente fra tutti
        quelli nel database.<br/>
        Il layout utilizzato presenta un header, una barra di
        navigazione (sfruttata anche per effettuare il login), un pannello
        laterale (suddiviso in menu utente e elenco categorie), un contenuto
        principale e un footer.<br/>
        Il pannello utente è visibile soltanto se è stato effettuato il login,
        e modifica il suo aspetto a seconda dei privilegi dell'utente che lo
        visualizza, aggiungendo o rimuovendo funzioni.<br/><br/>
        Ci tengo a specificare che il progetto non ha assolutamente la pretesa
        di essere <em>completo</em> nella funzione che dovrebbe svolgere, ma
        grazie all'utilizzo del pattern MVC l'applicazione è facilmente
        ampliabile.
    </p>
    <p class="sub-title overline">Requisiti</p>
    <p class="info-text">
        1. <strong>Utilizzo di HTML e CSS</strong><br/><br/>
        Sia il codice HTML utilizzato sia il CSS rispettano le specifiche e 
        superano con successo la validazione.<br/>
        Lo stile è statico (conserva le dimensioni indipendentemente da quelle
        della finestra del browser).<br/><br/>
        2. <strong>Utilizzo di PHP e MySQL</strong><br/><br/>
        L'applicazione è prevalentemente composta da codice php, e si appoggia
        interamente a un database SQL che conserva tutti i dati necessari al suo
        funzionamento. Anche le immagini dei prodotti sono contenute nel
        database, in modo da consentire una portabilità totale delle
        informazioni.<br/><br/>
        3. <strong>Utilizzo del pattern MVC</strong><br/><br/>
        AMM_WebApp è stata sviluppata utilizzando il pattern MVC.<br/>
        La prima parte ad essere stata implementata è proprio il Model, su cui
        si basano tutti gli spostamenti di dati (lettura o scrittura) che
        avvengono.<br/>
        Nella directory <code>/model</code> sono presenti le classi che
        rappresentano le entità utilizzate dall'applicazione. Ogni classe
        fornisce dei metodi che consentono di recuperare dal database le entità
        associate o di immagazzinare nuovi dati nel database, di fatto
        includendo dei veri e propri "Builder" al suo interno.<br/>
        La directory <code>/view</code> contiene tutti i file che compongono la
        vista che viene presentata all'utente. Ogni "sezione" della pagina ha un
        suo file specifico, garantendo modularità nella costruzione del
        progetto.<br/>
        Gli elementi vengono riutilizzati in diverse viste.<br/>
        Il controller è costituito da un controller principale, index.php, che
        grazie alle RewriteRule presenti nel file .htaccess riceve tutte le
        richieste in entrata e ne interpreta i parametri in modo da poter
        invocare il controller giusto per ogni richiesta.<br/>
        Tutti i controller specifici sono situati nella directory
        <code>/controller</code>.<br/><br/>
        4. <strong>Ruoli degli utenti</strong><br/><br/>
        Per il momento l'applicazione prevede l'esistenza di due sole categorie
        di utenti: utenti semplici o amministratori.<br/>
        Gli utenti base possono soltanto modificare i loro dati personali,
        mentre l'amministratore può gestire (modificare, aggiungere, cancellare)
        le categorie, aggiungere nuovi prodotti (è possibile anche inserire
        delle foto) o ripristinare lo stato del DB (abbastanza utile in fase di
        test).<br/><br/>
        5. <strong>Transazioni</strong><br/><br/>
        Al momento l'utilizzo delle transazioni è limitato ad un singolo caso,
        ovvero la cancellazione di una categoria.<br/>
        La cancellazione di una categoria comporta anche la cancellazione di
        tutti i prodotti che facciano parte della stessa, o di una qualsiasi
        categoria discendente.<br/>
        È stato quindi necessario assicurarsi che le query utilizzate
        avvenissero entrambe in modo da garantire la congruità dei dati nel
        database (protetti ulteriormente da un sistema di Foreign Keys)<br/>
        La classe Database.php fornisce i metodi statici
        <code>startTransaction()</code> e <code>commit()</code>, i quali
        rispettivamente avviano e terminano una transazione.<br/>
        La transazione viene utilizzata all'interno di
        <code>/controller/editcat.php</code>, linea 216.<br/><br/>
        6. <strong>AJAX/JQuery</strong><br/><br/>
        Nella home page è implementato uno scambio di informazioni col server
        utilizzando le tecniche AJAX.<br/>
        Tale scambio avviene ogni volta che si fa un click su una delle
        categorie nel pannello laterale, e il risultato è che il browser invia
        una richiesta all'applicazione per ricevere tutti i prodotti che
        corrispondono alla categoria clickata.<br/>
        Il codice si trova in <code>/scripts/default.js</code>.
        Il click sulla categoria espande o collassa le sottocategorie (il
        "doppio effetto" del click può risultare fastidioso, ma non ho fatto in
        tempo a escogitare un modo per ridurre l'area clickabile dei
        label).<br/>
    </p>
    <p class="sub-title overline">Link/Credenziali</p>
    <p class="info-text">
        La home page dell'applicazione si trova a 
        <a href="<?=$appPath?>/home">questo indirizzo</a>.
        Nel database sono presenti due utenti semplici:<br/><br/>
        <code>user: pippo | password: pippobaudo123</code><br/>
        <code>user: pluto | password: plutocane</code><br/><br/> 
        e un utente Amministratore:<br/><br/>
        <code>user: admin | password: ppabew_mma</code>
    </p>
</div>