<?php

namespace App\Repository;

class UserRepository {

    private $connection;

    public function __construct(PDOConnection $connection) {
        $this->connection = $connection->getConnection();
    }

    public function find($id) {
        $stmt = $this->connection->prepare('
            SELECT "User", users.* 
             FROM users 
             WHERE id = :id
        ');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        return $stmt->fetch();
    }

    public function findAll() {
        $stmt = $this->connection->prepare('
            SELECT * FROM users
        ');
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        return $stmt->fetchAll();
    }

    public function save(\User $user) {
        // If the ID is set, we're updating an existing record
        if (isset($user->id)) {
            return $this->update($user);
        }
        $stmt = $this->connection->prepare('
            INSERT INTO users 
                (username, firstname, lastname, email) 
            VALUES 
                (:username, :firstname , :lastname, :email)
        ');
        $stmt->bindParam(':username', $user->username);
        $stmt->bindParam(':firstname', $user->firstname);
        $stmt->bindParam(':lastname', $user->lastname);
        $stmt->bindParam(':email', $user->email);
        return $stmt->execute();
    }

    public function update(\User $user) {
        if (!isset($user->id)) {
            // We can't update a record unless it exists...
            throw new \LogicException(
            'Cannot update user that does not yet exist in the database.'
            );
        }
        $stmt = $this->connection->prepare('
            UPDATE users
            SET username = :username,
                firstname = :firstname,
                lastname = :lastname,
                email = :email
            WHERE id = :id
        ');
        $stmt->bindParam(':username', $user->username);
        $stmt->bindParam(':firstname', $user->firstname);
        $stmt->bindParam(':lastname', $user->lastname);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':id', $user->id);
        return $stmt->execute();
    }

}
