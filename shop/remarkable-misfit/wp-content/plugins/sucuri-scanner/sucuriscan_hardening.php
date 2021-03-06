<?php
/* Sucuri Security - SiteCheck Malware Scanner
 * Copyright (C) 2010-2012 Sucuri Security - http://sucuri.net
 * Released under the GPL - see LICENSE file for details.
 */


if(!defined('SUCURISCAN'))
{
    return(0);
}

/* Sucuri one-click hardening page. */

function sucuriscan_hardening_lib()
{
        echo '<h2 id="warnings_hook"></h2>';
        echo '<div class="postbox-container" style="width:75%;">';
            echo '<div class="sucuriscan-maincontent">';

                echo '<div class="postbox">';
                   echo '<div class="inside">';
                       echo '<h2 align="center">Help secure your WordPress install with <a href="http://sucuri.net/signup">Sucuri</a> 1-Click Hardening Options.</h2>';
                   echo '</div>';
                echo '</div>';

    include_once("lib/hardening.php");

    if(isset($_POST['wpsucuri-doharden']))
    {
        if(!wp_verify_nonce($_POST['sucuriscan_wphardeningnonce'], 'sucuriscan_wphardeningnonce'))
        {
            unset($_POST['wpsucuri-doharden']);
        }
    }

    ?>

        <div id="poststuff">

        <?php

            echo '<form action="" method="post">'.
                     '<input type="hidden" name="sucuriscan_wphardeningnonce" value="'.wp_create_nonce('sucuriscan_wphardeningnonce').'" />'.
                     '<input type="hidden" name="wpsucuri-doharden" value="wpsucuri-doharden" />'.

                        sucuriscan_harden_version();
                        sucuri_harden_removegenerator();
                        sucuriscan_harden_upload();
                        sucuriscan_harden_wpcontent();
                        sucuriscan_harden_wpincludes();
                        sucuriscan_harden_phpversion();
            echo '</form>'
            ?>

            <p align="center"><strong>If you have any questions about these checks or this plugin, contact us at <a href="mailto:info@sucuri.net">info@sucuri.net</a> or visit <a href="http://sucuri.net">Sucuri Security</a></strong></p>

        </div>

    <?php
}
