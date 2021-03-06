<?php
/*
 * Copyright 2008-2018 Anael Mobilia
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
require 'config/configV2.php';
require _TPL_TOP_;
?>
<h1><small>Historique des versions</small></h1>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h2 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#v21">
                v2.1 - en cours
                &nbsp;<span class="caret"></span>
            </a>
        </h2>
    </div>
    <div id="v20" class="panel-collapse">
        <div class="panel-body">
            <ul>
                <li>Migration jQuery 2 => 3</li>
                <li>Migration bootstrap 3 => 4</li>
                <li>Sélection uniquement des images lors du choix du fichier sur l'ordinateur</li>
                <li>Envoi de plusieurs images simultanément</li>
                <li>Glisser - déposer pour le choix des fichiers</li>
                <li>API permettant l'intégration à un site tiers</li>
                <li>Membres : Albums photos (création, affichage, partage)</li>
                <li>Membres : Permettre la connexion longue durée sur un ordinateur</li>
                <li>Membres : Permettre le changement de mot de passe</li>
                <li>Membres : Permettre de définir une valeur par défaut pour les paramètres des images à l'envoi</li>
                <li>Membres : Afficher les lines de partage dans l'espace membre</li>
                <li>Expliquer les avantages pour les personnes inscrites sur le site</li>
                <li>Meilleure gestion des statistiques d'affichage (trop d'appels à la base de données)</li>
            </ul>
        </div>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h2 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#v20">
                v2.0 - Novembre 2016
                &nbsp;<span class="caret"></span>
            </a>
        </h2>
    </div>
    <div id="v20" class="panel-collapse">
        <div class="panel-body">
            <ul>
                <li>Réactivation de l'ensemble des fonctionnalités du site (miniatures, retournement, ...)</li>
                <li>Modèle orienté objet pour une meilleure évolutivité sur le long terme</li>
                <li>Nouveau thème graphique</li>
                <li>Admin : Refonte de l'administration</li>
                <li>Admin : création de fonctions pour nettoyer les images oboslètes</li>
                <li>Reprise du schéma de la BDD</li>
                <li>Mise en place de tests automatisés sur l'ensemble des fonctionnalités du site</li>
            </ul>
        </div>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h2 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#v19">
                v1.9 - Janvier 2014
                &nbsp;<span class="caret"></span>
            </a>
        </h2>
    </div>
    <div id="v19" class="panel-collapse collapse">
        <div class="panel-body">
            <ul>
                <li>Passage à la programation objet</li>
                <li>Reprise, factorisation et optimisation globale du site</li>
            </ul>
        </div>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h2 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#v127">
                v1.2.7 - 26 avril 2012
                &nbsp;<span class="caret"></span>
            </a>
        </h2>
    </div>
    <div id="v127" class="panel-collapse collapse">
        <div class="panel-body">
            <ul>
                <li>Remise en place des options miniatures, rotation et redimensionnement</li>
                <li>Corrections de charset sur des messages d'erreur</li>
                <li>Amélioration de la protection anti-flood</li>
            </ul>
        </div>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h2 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#v126">
                v1.2.6 - 9 janvier 2012
                &nbsp;<span class="caret"></span>
            </a>
        </h2>
    </div>
    <div id="v126" class="panel-collapse collapse">
        <div class="panel-body">
            <ul>
                <li>Changement de serveur internet (la vitesse d'affichage est meilleure + connectivité IPv6 !)</li>
                <li>Changement d'encodage par défaut pour les pages et le code HTML <em>(passage en UTF-8)</em></li>
                <li>Gestion de l'IPv6 dans la BDD et les statistiques</li>
                <li>Sélection du contenu des champs contenants l'url de l'image au clic</li>
                <li>Amélioration du code HTML</li>
                <li>Refonte des CSS</li>
                <li>Préparation d'un système de templates</li>
                <li>Utilisation de jQuery : (box en haut de page, options cachées par défaut à l'envoi d'un fichier)</li>
            </ul>
        </div>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h2 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#v125">
                v1.2.5 - 30 octobre 2011
                &nbsp;<span class="caret"></span>
            </a>
        </h2>
    </div>
    <div id="v125" class="panel-collapse collapse">
        <div class="panel-body">
            <ul>
                <li>Suppression de la limite des dimensions d'images pour les utilisateurs enregistrés</li>
                <li>Ajout d'une fonction permettant le blocage d'images précises + affichage d'une image d'information sur le blocage</li>
            </ul>
        </div>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h2 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#v124">
                v1.2.4 - 08 septembre 2011
                &nbsp;<span class="caret"></span>
            </a>
        </h2>
    </div>
    <div id="v124" class="panel-collapse collapse">
        <div class="panel-body">
            <ul>
                <li>Meilleure gestion des images inexistantes (erreurs 404)</li>
            </ul>
        </div>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h2 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#v123e">
                v1.2.3.e - 14 août 2011
                &nbsp;<span class="caret"></span>
            </a>
        </h2>
    </div>
    <div id="v123e" class="panel-collapse collapse">
        <div class="panel-body">
            <ul>
                <li>Administration : suivi des requêtes SQL amélioré</li>
                <li>Finalisation de l'encodage des caractères spéciaux conformément à la norme HTML.</li>
                <li>Optimisation de la lisibilité du code source.</li>
                <li>Optimisation du temps d'éxecution du code PHP.</li>
            </ul>
        </div>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h2 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#v123d">
                v1.2.3.d - 10 août 2011
                &nbsp;<span class="caret"></span>
            </a>
        </h2>
    </div>
    <div id="v123d" class="panel-collapse collapse">
        <div class="panel-body">
            <ul>
                <li>Création du changelog.</li>
                <li>Encodage conforme à la norme HTML des caractères spéciaux.</li>
                <li>Correction d'une erreur PHP en cas d'envoi 'hack' de fichier.</li>
                <li>Amélioration de la portée des variables de language.</li>
            </ul>
        </div>
    </div>
</div>
<?php require _TPL_BOTTOM_ ?>