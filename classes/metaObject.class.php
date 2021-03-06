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

/**
 * Les méthodes "génériques"
 *
 * @author anael
 */
class metaObject {

   /**
    * Liste des images n'ayant jamais été affichées et présentes sur le serveur depuis une année
    * @return \ArrayObject
    */
   public static function getNeverUsedOneYear() {
      // Toutes les images jamais affichées & envoyées il y a plus d'un an
      $dateUnAn = date('Y-m-d', strtotime('-1year'));
      $req = "SELECT new_name FROM images where last_view = '0000-00-00' and date_envoi < '" . $dateUnAn . "' AND id NOT IN (SELECT image_id FROM possede)";

      // Exécution de la requête
      $resultat = maBDD::getInstance()->query($req);


      $retour = new ArrayObject();
      // Pour chaque résultat retourné
      foreach ($resultat->fetchAll() as $value) {
         // J'ajoute le nom de l'image
         $retour->append($value->new_name);
      }

      return $retour;
   }

   /**
    * Liste des images n'ayant pas été affichées les trois dernières années
    * @return \ArrayObject
    */
   public static function getUnusedThreeYear() {
      // Toutes les images jnon affichées depuis 3 ans
      $dateTroisAns = date('Y-m-d', strtotime('-3year'));
      $req = "SELECT new_name FROM images where last_view < '" . $dateTroisAns . "' AND date_envoi < '" . $dateTroisAns . "' AND id NOT IN (SELECT image_id FROM possede)";

      // Exécution de la requête
      $resultat = maBDD::getInstance()->query($req);


      $retour = new ArrayObject();
      // Pour chaque résultat retourné
      foreach ($resultat->fetchAll() as $value) {
         // J'ajoute le nom de l'image
         $retour->append($value->new_name);
      }

      return $retour;
   }

   /**
    * Liste de l'ensemble des images en BDD
    * @return \ArrayObject
    */
   public static function getAllImagesNameBDD() {
      // Toutes les images (sauf 404 & banned)
      $req = "SELECT md5 FROM images WHERE id > 2";

      // Exécution de la requête
      $resultat = maBDD::getInstance()->query($req);

      $retour = new ArrayObject();
      // Pour chaque résultat retourné
      foreach ($resultat->fetchAll() as $value) {
         // J'ajoute le nom de l'image
         $retour->append($value->md5);
      }

      return $retour;
   }

   /**
    * Liste de l'ensemble des images en HDD
    * @param type $path path à analyser
    * @return \ArrayObject
    */
   public static function getAllImagesNameHDD($path) {
      $monRetour = new ArrayObject();

      // Scanne le répertoire des images
      $scan_rep = scandir($path);
      // Pour chaque item
      foreach ($scan_rep as $item) {
         if ($item !== '.' && $item !== '..' && $item !== '_dummy') {
            if (is_dir($path . $item)) {
               // Appel récursif
               if ($path . $item . '/' !== _PATH_MINIATURES_) {
                  $monRetourTmp = self::getAllImagesNameHDD($path . $item . '/');
                  // Parsage et récupération des sous fichiers...
                  foreach ($monRetourTmp as $fichier) {
                     $monRetour->append($fichier);
                  }
               }
            } elseif ($item !== _IMAGE_404_ && $item !== _IMAGE_BAN_) {
               $monRetour->append($item);
            }
         }
      }

      return $monRetour;
   }

   /**
    * Liste de l'ensemble des miniatures en BDD
    */
   public static function getAllMiniaturesNameBDD() {
      // Toutes les images
      $req = "SELECT thumbnails.md5 FROM images, thumbnails WHERE images.id = thumbnails.id";

      // Exécution de la requête
      $resultat = maBDD::getInstance()->query($req);


      $retour = new ArrayObject();
      // Pour chaque résultat retourné
      foreach ($resultat->fetchAll() as $value) {
         // J'ajoute le nom de l'image
         $retour->append($value->md5);
      }

      return $retour;
   }

   /**
    * Toutes les images appartenant à un utilisateur
    * @param type $userId ID de l'user en question
    * @return \ArrayObject new_name image
    */
   public static function getAllPicsOffOneUser($userId) {
      // Toutes les images
      $req = maBDD::getInstance()->prepare("SELECT new_name FROM possede, images WHERE id = image_id AND pk_membres = ? ");
      /* @var $req PDOStatement */
      $req->bindValue(1, $userId, PDO::PARAM_INT);

      // Exécution de la requête
      $req->execute();

      $retour = new ArrayObject();
      // Pour chaque résultat retourné
      foreach ($req->fetchAll() as $value) {
         // J'ajoute le nom de l'image
         $retour->append($value->new_name);
      }

      return $retour;
   }

   /**
    * Vérifie que l'utilisateur à le droit d'afficher la page et affiche un EM au cas où
    * @param type $levelRequis
    */
   public static function checkUserAccess($levelRequis) {
      $monUser = new sessionObject();
      if ($monUser->verifierDroits($levelRequis) === FALSE) {
         require _TPL_TOP_;
         ?>
         <h1>Accès refusé</h1>
         <p>Désolé, vous n'avez pas le droit d'accèder à cette page.</p>
         <?php
         require _TPL_BOTTOM_;
         die();
      }
   }

   /**
    * Vérifier si un login est disponible pour enregistrement
    * @param type $login
    * @return boolean
    */
   public static function verifierLoginDisponible($login) {
      $req = maBDD::getInstance()->prepare("SELECT * FROM membres WHERE login = ?");
      /* @var $req PDOStatement */
      $req->bindValue(1, $login, PDO::PARAM_STR);
      $req->execute();

      // Par défaut le login est disponible
      $retour = TRUE;

      // Si j'ai un résultat...
      if ($req->fetch()) {
         // Le retour est négatif
         $retour = FALSE;
      }

      return $retour;
   }

}