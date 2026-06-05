<?php


class Contact
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(
        $nom,
        $email,
        $sujet,
        $message,
        $id_client
    )
    {
        $sql = "INSERT INTO contact
                (
                    nom,
                    email,
                    sujet,
                    message,
                    date_message,
                    id_client
                )
                VALUES
                (
                    :nom,
                    :email,
                    :sujet,
                    :message,
                    NOW(),
                    :id_client
                )";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nom' => $nom,
            ':email' => $email,
            ':sujet' => $sujet,
            ':message' => $message,
            ':id_client' => $id_client
        ]);
    }

    public function getAll()
    {
        $sql = "SELECT *
                FROM contact
                ORDER BY date_message DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
