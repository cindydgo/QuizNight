<?php

class Question {
    // Propriétés de la classe
    private $question;
    private $reponse;
    private $bonneReponse;

    // Constructeur pour initialiser les propriétés
    public function __construct($question, $reponse, $bonneReponse) {
        $this->question = $question;
        $this->reponse = $reponse;
        $this->bonneReponse = $bonneReponse;
    }

    // Méthodes pour accéder aux propriétés (getters)
    public function getQuestion() {
        return $this->question;
    }

    public function getReponse() {
        return $this->reponse;
    }

    public function getBonneReponse() {
        return $this->bonneReponse;
    }
    
    /* public function addQuestion($question, $reponses) {
        $this->questions[] = ['question' => $question, 'reponses' => $reponses];
    } */
    
    // Méthode pour modifier les informations (setters)
    public function setQuestion($question) {
        $this->question = $question;
    }

    public function setReponse($reponse) {
        $this->reponse = $reponse;
    }

    // Méthode pour vérifier si la réponse donnée est correcte
    public function verifierReponse($reponseDonnee) {
        return $reponseDonnee === $this->bonneReponse;
    }
}
?>