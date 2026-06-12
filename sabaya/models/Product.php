<?php

class Product
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $sql = "SELECT produits.*, categorie.nom AS categorie_nom
                FROM produits
                INNER JOIN categorie
                ON produits.id_categorie = categorie.id_categorie
                ORDER BY id_produit DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $sql = "SELECT produits.*, categorie.nom AS categorie_nom
                FROM produits
                LEFT JOIN categorie
                ON produits.id_categorie = categorie.id_categorie
                WHERE id_produit = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch();
    }

    public function create(
        $nom,
        $description,
        $prix,
        $stock,
        $image,
        $taille,
        $couleur,
        $id_categorie
    )
    {
        $sql = "INSERT INTO produits
                (
                    nom,
                    description,
                    prix,
                    stock,
                    image,
                    taille,
                    couleur,
                    id_categorie
                )
                VALUES
                (
                    :nom,
                    :description,
                    :prix,
                    :stock,
                    :image,
                    :taille,
                    :couleur,
                    :id_categorie
                )";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nom' => $nom,
            ':description' => $description,
            ':prix' => $prix,
            ':stock' => $stock,
            ':image' => $image,
            ':taille' => $taille,
            ':couleur' => $couleur,
            ':id_categorie' => $id_categorie
        ]);
    }

    public function update(
        $id,
        $nom,
        $description,
        $prix,
        $stock,
        $image,
        $taille,
        $couleur,
        $id_categorie
    )
    {
        $sql = "UPDATE produits
                SET
                    nom = :nom,
                    description = :description,
                    prix = :prix,
                    stock = :stock,
                    image = :image,
                    taille = :taille,
                    couleur = :couleur,
                    id_categorie = :id_categorie
                WHERE id_produit = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':nom' => $nom,
            ':description' => $description,
            ':prix' => $prix,
            ':stock' => $stock,
            ':image' => $image,
            ':taille' => $taille,
            ':couleur' => $couleur,
            ':id_categorie' => $id_categorie
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM produits
                WHERE id_produit = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
    public function search($keyword)
{
    $sql = "SELECT produits.*, categorie.nom AS categorie_nom
            FROM produits
            INNER JOIN categorie
            ON produits.id_categorie = categorie.id_categorie
            WHERE produits.nom LIKE :keyword
            ORDER BY produits.nom ASC";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        ':keyword' => '%' . $keyword . '%'
    ]);

    return $stmt->fetchAll();
}
public function getByCategory($id_categorie)
{
    $sql = "SELECT produits.*, categorie.nom AS categorie_nom
            FROM produits
            INNER JOIN categorie
            ON produits.id_categorie = categorie.id_categorie
            WHERE produits.id_categorie = :id_categorie
            ORDER BY produits.id_produit DESC";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        ':id_categorie' => $id_categorie
    ]);

    return $stmt->fetchAll();
}
}