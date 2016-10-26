<?php
/*
 * Copyright 2008-2016 Anael Mobilia
 *
 * This file is part of image-heberg.fr.
 *
 * image-heberg.fr is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * image-heberg.fr is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with image-heberg.fr. If not, see <http://www.gnu.org/licenses/>
 */

/**
 * CONFIGURATION FILE FOR TRAVIS
 * https://travis-ci.org/AnaelMobilia/image-heberg.fr/
 */
// DEBUG
define('_DEBUG_', TRUE);
if (_DEBUG_) {
    error_reporting(E_ALL | E_STRICT);
}

// Gestion des exceptions de l'application
function exception_handler($exception) {
    /* @var $exception Exception */
    if (_DEBUG_) {
        echo '<pre>';
        print_r($exception->getMessage());
        echo '<br /><br /><hr /><br />';
        print_r($exception->getTraceAsString());
        echo '</pre>';
    } else {
        echo 'Une erreur a été rencontrée';
        // TODO : log de l'erreur / mail
    }
}

set_exception_handler('exception_handler');

// mail admin
define('_MAIL_ADMIN_', 'contrib@anael.eu');

// URL
define('_URL_', 'http://www.image-heberg.fr/');
define('_URL_ADMIN_', _URL_ . 'admin/');
define('_URL_MEMBRE_', _URL_ . 'membre/');
define('_URL_IMAGES_', _URL_ . 'files/');
define('_URL_MINIATURES_', _URL_IMAGES_ . 'thumbs/');

// Système de fichiers
define('_PATH_', '/home/travis/build/AnaelMobilia/image-heberg.fr/');
define('_PATH_IMAGES_', _PATH_ . 'files/');
define('_PATH_MINIATURES_', _PATH_IMAGES_ . 'thumbs/');
define('_PATH_ADMIN_', _PATH_ . 'admin/');
define('_TPL_TOP_', _PATH_ . 'template/templateV2Top.php');
define('_TPL_BOTTOM_', _PATH_ . 'template/templateV2Bottom.php');

// Salt pour les mots de passe
define('_GRAIN_DE_SEL_', '123456789azertyuiop');

// BDD
define('_BDD_HOST_', 'localhost');
define('_BDD_USER_', 'root');
define('_BDD_PASS_', '');
define('_BDD_NAME_', 'imageheberg');

// Administrateur du site
define('_ADMINISTRATEUR_NOM_', 'Anael MOBILIA');
define('_ADMINISTRATEUR_SITE_', 'http://www.anael.eu/');

// Hébergeur du site
define('_HEBERGEUR_NOM_', 'OVH');
define('_HEBERGEUR_SITE_', 'http://www.ovh.com');

// Fonction de chargement des classes en cas de besoin
spl_autoload_register(function ($class) {
    // Code spécifique Travis : pas de chargement des classes de PHPUnit
    if (strpos($class, "PHPUnit")) {
        require _PATH_ . 'classes/' . $class . '.class.php';
    }
    throw new Exception($class);
});

// Connexion centralisée à la BDD
$maBDD = new PDO('mysql:host=' . _BDD_HOST_ . ';dbname=' . _BDD_NAME_, _BDD_USER_, _BDD_PASS_);
$maBDD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$maBDD->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
?>