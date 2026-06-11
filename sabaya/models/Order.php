<?php

class Order
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createAddress($ville, $adresse, $code_postal, $id_client)
    {
        $sql = "INSERT INTO adresse
                (ville, adresse, code_postal, id_client)
                VALUES
                (:ville, :adresse, :code_postal, :id_client)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':ville' => $ville,
            ':adresse' => $adresse,
            ':code_postal' => $code_postal,
            ':id_client' => $id_client
        ]);

        return $this->pdo->lastInsertId();
    }

    public function createOrder($id_client, $total)
    {
        $sql = "INSERT INTO commande
                (
                    datecmd,
                    statuscmd,
                    total,
                    id_client
                )
                VALUES
                (
                    NOW(),
                    'En attente',
                    :total,
                    :id_client
                )";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':total'     => $total,
            ':id_client' => $id_client
        ]);

        return $this->pdo->lastInsertId();
    }

    // ── Transaction helpers ──────────────────────────────────────────────────
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    public function commit()
    {
        return $this->pdo->commit();
    }

    public function rollBack()
    {
        return $this->pdo->rollBack();
    }

    public function createOrderLine($qte, $prix, $id_commande, $id_produit)
    {
        $sql = "INSERT INTO ligne_commande
                (
                    qte,
                    prix,
                    id_commande,
                    id_produit
                )
                VALUES
                (
                    :qte,
                    :prix,
                    :id_commande,
                    :id_produit
                )";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':qte' => $qte,
            ':prix' => $prix,
            ':id_commande' => $id_commande,
            ':id_produit' => $id_produit
        ]);
    }
    public function getUserOrders($id_client)
{
$sql = "SELECT *
FROM commande
WHERE id_client = :id_client
ORDER BY id_commande DESC";

$stmt = $this->pdo->prepare($sql);

$stmt->execute([
    ':id_client' => $id_client
]);

return $stmt->fetchAll();


}
public function getAllOrders()
{
$sql = "SELECT
commande.*,
client.nom,
client.prenom
FROM commande
INNER JOIN client
ON commande.id_client = client.id_client
ORDER BY commande.id_commande DESC";
$stmt = $this->pdo->prepare($sql);
$stmt->execute();

return $stmt->fetchAll();


}

public function getOrderById($id_commande)
{
    $sql = "SELECT commande.*, client.nom, client.prenom, client.email, client.telephone
            FROM commande
            INNER JOIN client
            ON commande.id_client = client.id_client
            WHERE commande.id_commande = :id_commande";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        ':id_commande' => $id_commande
    ]);

    return $stmt->fetch();
}

public function getOrderItems($id_commande)
{
    $sql = "SELECT ligne_commande.*, produits.nom AS produit_nom, produits.image
            FROM ligne_commande
            INNER JOIN produits
            ON ligne_commande.id_produit = produits.id_produit
            WHERE ligne_commande.id_commande = :id_commande";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        ':id_commande' => $id_commande
    ]);

    return $stmt->fetchAll();
}

public function updateStatus($id_commande, $status)
{
$sql = "UPDATE commande
SET statuscmd = :status
WHERE id_commande = :id_commande";


$stmt = $this->pdo->prepare($sql);

return $stmt->execute([
    ':status' => $status,
    ':id_commande' => $id_commande
]);


}


}