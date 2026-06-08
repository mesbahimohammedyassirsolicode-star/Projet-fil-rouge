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
        $sql = "SELECT * FROM categorie ORDER BY nom ASC";

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

    public function findByName($nom)
    {
        $sql = "SELECT * FROM categorie
                WHERE nom = :nom";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':nom' => $nom
        ]);

        return $stmt->fetch();
    }

    public function create($nom, $image = null)
    {
        $sql = "INSERT INTO categorie (nom, image)
                VALUES (:nom, :image)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nom'   => $nom,
            ':image' => $image
        ]);
    }

    public function update($id, $nom, $image = null)
    {
        if ($image !== null) {
            $sql = "UPDATE categorie
                    SET nom = :nom, image = :image
                    WHERE id_categorie = :id";

            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([
                ':nom'   => $nom,
                ':image' => $image,
                ':id'    => $id
            ]);
        } else {
            $sql = "UPDATE categorie
                    SET nom = :nom
                    WHERE id_categorie = :id";

            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([
                ':nom' => $nom,
                ':id'  => $id
            ]);
        }
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