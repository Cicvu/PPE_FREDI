<?php

class TresorierDAO extends DAO{
    
    function __construct(){
        parent::__construct();
    }
    
    function insert(Tresorier $tresorier) {
        $sql = "INSERT INTO trésorier (nomTresorier, prenomTresorier) ";
        $sql .="VALUES (:marque, :modele)";
        $params = array(
            ":nomTresorier" => $tresorier->get_nomTresorier(),
            ":prenomTresorier" => $tresorier->get_prenomTresorier()
        );
        $sth = $this->executer($sql, $params); // On passe par la méthode de la classe mère
        $nb = $sth->rowcount();
        return $nb; // Retourne le nombre de mise à jour
    }
    
    function update(Tresorier $tresorier) {
        $sql = "UPDATE trésorier SET nomTresorier=:nomTresorier, prenomTresorier=:prenomTresorier WHERE idTresorier=:idTresorier";
        $params = array(
            ":idTresorier" => $tresorier->get_idTresorier(),
            ":nomtresorier" => $tresorier->get_nomTresorier(),
            ":prenomTresorier" => $tresorier->get_prenomTresorier()
        );
        $sth = $this->executer($sql, $params); // On passe par la méthode de la classe mère
        $nb = $sth->rowcount();
        return $nb;
    }
    
    function delete($tresorier) {
        $sql = "DELETE FROM trésorier WHERE idTresorier=:idTresorier";
        $params = array(
            ":idTresorier" => $tresorier->get_idTresorier()
        );
        $sth = $this->executer($sql, $params); // On passe par la méthode de la classe mère
        $nb = $sth->rowcount();
        return $nb; // Retourne le nombre de mise à jour
    }
    
    function find($idTresorier) {
        $sql = "SELECT * FROM trésorier WHERE idTresorier= :idTresorier";
        try {
            $sth = $this->pdo->prepare($sql);
            $sth->execute(array(":idTresorier" => $idTresorier));
            $row = $sth->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
        }
        $idTresorier = new FrediDAO($row);
        // Retourne l'objet métier
        return $idTresorier;
    } // function find()
    
}

function findAll() {
    $sql = "SELECT * FROM trésorier";
    try {
        $sth = $this->pdo->prepare($sql);
        $sth->execute();
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    $tresorier = array();
    foreach ($rows as $row) {
        $tresorier[] = new Tresorier($row);
    }
    // Retourne un tableau d'objets "tresorier"
    return $tresorier;
}

?>