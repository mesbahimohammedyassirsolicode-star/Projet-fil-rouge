<?php

class Category
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM categorie ORDER BY id_categorie ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $sql = "SELECT * FROM categorie
                WHERE id_categorie = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch();
    }

    public function create($nom)
    {
        $sql = "INSERT INTO categorie (nom)
                VALUES (:nom)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nom' => $nom
        ]);
    }

    public function update($id, $nom)
    {
        $sql = "UPDATE categorie
                SET nom = :nom
                WHERE id_categorie = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nom' => $nom,
            ':id' => $id
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM categorie
                WHERE id_categorie = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}