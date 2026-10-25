<?php
namespace App\Entity;

abstract class AbstractEntity {

    // Crée l'objet et le remplit avec les données reçues
    public function __construct(array $data = []) {
        $this->hydrate($data);
    }

    // Hydratation : pour chaque clé du tableau, appelle le setter correspondant
    // ex. ['user_id' => 3] appelle setUserId(3)
    public function hydrate(array $data): void {
        foreach ($data as $cle => $valeur) {
            // 'user_id' devient 'setUserId'
            $methode = 'set' . str_replace('_', '', ucwords($cle, '_'));

            if (method_exists($this, $methode)) {
                $this->$methode($valeur);
            }
        }
    }
}