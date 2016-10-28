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
// DEBUG
define('_DEBUG_', TRUE);
if (_DEBUG_) {
    error_reporting(E_ALL | E_STRICT);
}
// Tests TRAVIS-CI
define('_TRAVIS_', FALSE);

if (!_TRAVIS_) {

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
}

// mail admin
define('_MAIL_ADMIN_', 'john.doe@example.com');

// Répertoires
define('_REPERTOIRE_IMAGE_', 'files/');
define('_REPERTOIRE_MINIATURE_', _REPERTOIRE_IMAGE_ . 'thumbs/');
define('_REPERTOIRE_ADMIN_', 'admin/');
define('_REPERTOIRE_MEMBRE_', 'membre/');

// URL
define('_URL_', 'http://www.image-heberg.fr/');
define('_URL_ADMIN_', _URL_ . _REPERTOIRE_ADMIN_);
define('_URL_MEMBRE_', _URL_ . _REPERTOIRE_MEMBRE_);
define('_URL_IMAGES_', _URL_ . _REPERTOIRE_IMAGE_);
define('_URL_MINIATURES_', _URL_ . _REPERTOIRE_MINIATURE_);

// Système de fichiers
define('_PATH_', '/path/to/image-heberg.fr/');
define('_PATH_IMAGES_', _PATH_ . _REPERTOIRE_IMAGE_);
define('_PATH_MINIATURES_', _PATH_ . _REPERTOIRE_MINIATURE_);
define('_PATH_ADMIN_', _PATH_ . _REPERTOIRE_ADMIN_);
define('_PATH_TESTS_IMAGES_', _PATH_ . '__tests/images/');
define('_PATH_TESTS_OUTPUT_', _PATH_ . '__tests/output/');
define('_TPL_TOP_', _PATH_ . 'template/templateV2Top.php');
define('_TPL_BOTTOM_', _PATH_ . 'template/templateV2Bottom.php');

// Images spécifiques
define('_IMAGE_404_', '_image_404.png');
define('_IMAGE_BAN_', '_image_banned.png');

// Salt pour les mots de passe
define('_GRAIN_DE_SEL_', 'xxx');

// BDD
define('_BDD_HOST_', 'xxx');
define('_BDD_USER_', 'xxx');
define('_BDD_PASS_', 'xxx');
define('_BDD_NAME_', 'xxx');

// Administrateur du site
define('_ADMINISTRATEUR_NOM_', 'Anael MOBILIA');
define('_ADMINISTRATEUR_SITE_', 'http://www.anael.eu/');

// Hébergeur du site
define('_HEBERGEUR_NOM_', 'OVH');
define('_HEBERGEUR_SITE_', 'http://www.ovh.com');

// Fonction de chargement des classes en cas de besoin
spl_autoload_register(function ($class) {
    // Code pour TRAVIS
    $charger = TRUE;

    // Code spécifique Travis : pas de chargement des classes de PHPUnit
    if (_TRAVIS_ && (strpos($class, "PHPUnit") !== FALSE || strpos($class, "Composer") !== FALSE)) {
        $charger = FALSE;
    }

    if ($charger) {
        require _PATH_ . 'classes/' . $class . '.class.php';
    }
});
?>