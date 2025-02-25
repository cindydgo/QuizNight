<?php

class User {
    // Propriétés de la classe
    private $name;
    private $email;
    private $age;
    private $registerdate;

    // Constructeur pour initialiser les propriétés
    public function __construct($name, $email, $registerdate, $age) {
        $this->name = $name;
        $this->email = $email;
        $this->registerdate = $registerdate;
        $this->age = $age;
    }

    // Méthodes pour accéder aux propriétés (getters)
    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getAge() {
        return $this->age;
    }

    public function getDate() {
        return $this->registerdate;
    }

    // Méthode pour modifier les informations (setters)
    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    // Exemple de méthode pour valider l'email
    public function isValidEmail() {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

?>