<?php

class Wishlist
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function add($id_client, $id_produit)
    {
        $check = $this->pdo->prepare(
            "SELECT id_wishlist
             FROM wishlist
             WHERE id_client = :id_client
             AND id_produit = :id_produit"
        );

        $check->execute([
            ':id_client' => $id_client,
            ':id_produit' => $id_produit
        ]);

        if ($check->fetch()) {
            return true;
        }

        $sql = "INSERT INTO wishlist
                (
                    id_client,
                    id_produit
                )
                VALUES
                (
                    :id_client,
                    :id_produit
                )";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id_client' => $id_client,
            ':id_produit' => $id_produit
        ]);
    }

    public function getUserWishlist($id_client)
    {
        $sql = "SELECT
                    wishlist.*,
                    produits.nom,
                    produits.prix,
                    produits.image
                FROM wishlist
                INNER JOIN produits
                    ON wishlist.id_produit = produits.id_produit
                WHERE wishlist.id_client = :id_client
                ORDER BY wishlist.id_wishlist DESC";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id_client' => $id_client
        ]);

        return $stmt->fetchAll();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM wishlist
                WHERE id_wishlist = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}