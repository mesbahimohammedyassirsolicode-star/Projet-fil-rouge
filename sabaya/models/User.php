<?php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM client ORDER BY id_client ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $sql = "SELECT * FROM client
                WHERE id_client = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM client
                WHERE id_client = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function getOrderCount($id)
    {
        $sql = "SELECT COUNT(*) AS total_orders
                FROM commande
                WHERE id_client = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        $result = $stmt->fetch();

        return $result['total_orders'];
    }

    public function getUserOrders($id)
    {
        $sql = "SELECT * FROM commande
                WHERE id_client = :id
                ORDER BY id_commande DESC";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetchAll();
    }
}