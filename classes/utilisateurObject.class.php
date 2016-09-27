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
 * Gestion (BDD) des utilisateurs
 *
 * @author anael
 */
class utilisateurObject {

    private $userName;
    private $password;
    private $email;
    private $dateInscription;
    private $ipInscription;
    private $tpl;
    private $level;
    private $id;
    private $redirectUpload;

    // Niveaux de droits
    const levelGuest = 0;
    const levelUser = 1;
    const levelAdmin = 2;
    // Noms des tables
    const tableNameUtilisateur = 'membres';
    const tableNameLoginHistory = 'login';
    const tableNamePossede = 'possede';

    public function __construct($userID = FALSE) {
        // Utilisateur à charger
        if ($userID) {
            $this->charger($userID);
        }
        // Cas par défaut
        else {
            $this->setLevel(utilisateurObject::levelGuest);
            $this->setId(0);
        }
    }

    /**
     * Nom d'utilisateur avec htmlentities
     * @return type
     */
    public function getUserName() {
        return htmlentities($this->userName);
    }

    /**
     * BDD - Nom d'utilisateur non htmlentities
     * @return type
     */
    public function getUserNameBDD() {
        return $this->userName;
    }

    /**
     * Mot de passe
     * @return type
     */
    private function getPassword() {
        return $this->password;
    }

    /**
     * Mot de passe crypté version BDD
     * @return type
     */
    private function getPasswordEncrypted() {
        return hash('sha256', _GRAIN_DE_SEL_ . $this->getPassword());
    }

    /**
     * Email
     * @return type
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Date d'inscription
     * @return type
     */
    private function getDateInscription() {
        return $this->dateInscription;
    }

    /**
     * Date d'inscription formatée
     * @return type
     */
    public function getDateInscriptionFormate() {
        $phpdate = strtotime($this->dateInscription);
        return date("d/m/Y", $phpdate);
    }

    /**
     * @ IP d'inscription
     * @return type
     */
    public function getIpInscription() {
        return $this->ipInscription;
    }

    /**
     * Template utilisé
     * @return type
     */
    public function getTpl() {
        return $this->tpl;
    }

    /**
     * Niveau de droits
     * @return type
     */
    public function getLevel() {
        return $this->level;
    }

    /**
     * ID en BDD
     * @return type
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Redirection vers la page d'upload à la connexion à l'espace membre
     * @return type
     */
    public function getRedirectUpload() {
        return $this->redirectUpload;
    }

    /**
     * Nom d'utilisateur
     * @param type $userName
     */
    public function setUserName($userName) {
        $this->userName = $userName;
    }

    /**
     * Mot de passe
     * @param type $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * Email
     * @param type $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Date d'inscription
     * @param type $dateInscription
     */
    public function setDateInscription($dateInscription) {
        $this->dateInscription = $dateInscription;
    }

    /**
     * @ IP d'inscription
     * @param type $ipInscription
     */
    public function setIpInscription($ipInscription) {
        $this->ipInscription = $ipInscription;
    }

    /**
     * Template utilisé
     * @param type $tpl
     */
    public function setTpl($tpl) {
        $this->tpl = $tpl;
    }

    /**
     * Niveau de droits
     * @param type $level
     */
    public function setLevel($level) {
        $this->level = $level;
    }

    /**
     * ID en BDD
     * @param type $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Redirection vers la page d'upload à la connexion à l'espace membre
     * @param type $redirectUpload
     */
    public function setRedirectUpload($redirectUpload) {
        $this->redirectUpload = $redirectUpload;
    }

    /**
     * Connexion d'un utilisateur : vérification & création de la session
     * @global type $maBDD
     * @return boolean
     */
    public function connexion() {
        global $maBDD;

        // Le sessionObject qui sera retourné
        $monUser = new sessionObject();

        $req = $maBDD->prepare("SELECT * FROM " . utilisateurObject::tableNameUtilisateur . " WHERE login = ?");
        /* @var $req PDOStatement */
        $req->bindValue(1, $this->getUserName(), PDO::PARAM_STR);
        $req->execute();

        // Je récupère les potentielles valeurs
        $values = $req->fetch();

        // Si l'utilisateur n'existe pas... on retourne un sessionObject vide
        if ($values === FALSE) {
            return FALSE;
        }

        // Si les mots de passe ne correspondent pas... on retourne un sessionObject vide
        if ($this->getPasswordEncrypted() !== $values->pass) {
            return FALSE;
        }

        // Je charge les informations de la session
        $monUser->setIP($_SERVER['REMOTE_ADDR']);
        $monUser->setId($values->pk_membres);
        $monUser->setLevel($values->lvl);
        $monUser->setUserName($values->login);

        // J'enregistre en BDD la connexion réussie
        $req = $maBDD->prepare("INSERT INTO " . utilisateurObject::tableNameLoginHistory . " (ip_login, date_login, pk_membres) VALUES (?, NOW(), ?)");
        $req->bindValue(1, $monUser->getIP(), PDO::PARAM_STR);
        $req->bindValue(2, $monUser->getId(), PDO::PARAM_INT);

        $req->execute();
        // On dit que tout s'est bien passé
        return TRUE;
    }

    /**
     * Charge un utilisateur depuis la BDD
     * @param int $userID ID en BDD
     */
    public function charger($userID) {
        global $maBDD;

        // Je récupère les données en BDD
        $req = $maBDD->prepare("SELECT * FROM " . utilisateurObject::tableNameUtilisateur . " WHERE pk_membres = ?");
        /* @var $req PDOStatement */
        $req->bindValue(1, $userID, PDO::PARAM_INT);
        $req->execute();

        // Je récupère les potentielles valeurs
        $values = $req->fetch();

        // Si l'utilisateur n'existe pas... on retourne un utilisateurObject vide
        if ($values === FALSE) {
            return FALSE;
        }

        // Je charge les informations de l'utilisateur
        $this->setId($userID);
        $this->setEmail($values->email);
        $this->setUserName($values->login);
        $this->setPassword($values->pass);
        $this->setDateInscription($values->date_inscription);
        $this->setIpInscription($values->ip_inscription);
        $this->setRedirectUpload($values->redirect_upload);
        $this->setTpl($values->tpl);
        $this->setLevel($values->lvl);
    }

    /**
     * Enregistrement (BDD) d'un utilisateur
     */
    public function enregistrer() {
        global $maBDD;

        $req = $maBDD->prepare("INSERT INTO " . utilisateurObject::tableNameUtilisateur . " (email, login, pass, date_inscription, ip_inscription, redirect_upload, tpl, lvl) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?)");
        $req->bindValue(1, $this->getEmail(), PDO::PARAM_STR);
        $req->bindValue(2, $this->getUserNameBDD(), PDO::PARAM_STR);
        $req->bindValue(3, $this->getPasswordEncrypted(), PDO::PARAM_STR);
        $req->bindValue(4, $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
        $req->bindValue(5, $this->getRedirectUpload(), PDO::PARAM_INT);
        $req->bindValue(6, $this->getTpl(), PDO::PARAM_STR);
        $req->bindValue(7, $this->getLevel(), PDO::PARAM_INT);

        $req->execute();
    }

    /**
     * Modifier (BDD) un utilisateur déjà existant
     */
    public function modifier() {
        global $maBDD;

        $req = $maBDD->prepare("UPDATE " . utilisateurObject::tableNameUtilisateur . " SET email = ?, login = ?, pass = ?, redirect_upload = ?, tpl = ?, lvl = ? WHERE pk_membres = ?");
        $req->bindValue(1, $this->getEmail(), PDO::PARAM_STR);
        $req->bindValue(2, $this->getUserNameBDD(), PDO::PARAM_STR);
        $req->bindValue(3, $this->getPasswordEncrypted(), PDO::PARAM_STR);
        $req->bindValue(4, $this->getRedirectUpload(), PDO::PARAM_INT);
        $req->bindValue(5, $this->getTpl(), PDO::PARAM_STR);
        $req->bindValue(6, $this->getLevel(), PDO::PARAM_INT);
        $req->bindValue(7, $this->getId(), PDO::PARAM_INT);

        $req->execute();
    }

    /**
     * Suppression (BDD) d'un utilisateur
     */
    public function supprimer() {
        global $maBDD;

        // Les images possédées
        $req = $maBDD->prepare("DELETE FROM " . utilisateurObject::tableNamePossede . " WHERE pk_membres = ?");
        $req->bindValue(1, $this->getId(), PDO::PARAM_INT);
        $req->execute();

        // Historique des logins
        $req = $maBDD->prepare("DELETE FROM " . utilisateurObject::tableNameLoginHistory . " WHERE pk_membres = ?");
        $req->bindValue(1, $this->getId(), PDO::PARAM_INT);
        $req->execute();

        // Paramètres du compte
        $req = $maBDD->prepare("DELETE FROM " . utilisateurObject::tableNameUtilisateur . " WHERE pk_membres = ?");
        $req->bindValue(1, $this->getId(), PDO::PARAM_INT);
        $req->execute();
    }

    /**
     * Vérifie si le mot de passe fourni est bien celui de l'utilisateur
     * @param type $password
     */
    public function checkPassword($password) {
        // Je créée un nouvel utilisateur pour encrypter le mot de passe
        $monUtilisateurTest = new utilisateurObject();
        $monUtilisateurTest->setPassword($password);

        // Comparons (le mdp local est toujours encrypté quand je charge depuis la BDD un utilisateur)
        if ($monUtilisateurTest->getPasswordEncrypted() === $this->getPassword()) {
            return TRUE;
        }
        return FALSE;
    }

}
