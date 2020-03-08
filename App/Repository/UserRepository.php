<?php

namespace App\Repository;


use App\Data\UserDTO;
use Core\DataBinderInterface;
use Database\DatabaseInterface;

class UserRepository extends DatabaseAbstract implements UserRepositoryInterface
{

    public function __construct(DatabaseInterface $database, DataBinderInterface $dataBinder)
    {
        parent::__construct($database, $dataBinder);
    }

    public function insert(UserDTO $userDTO): bool
    {
        $this->db->query(
            'INSERT INTO users(email, password, full_name)
                    VALUES (?, ?, ?)'
        )->execute([
            $userDTO->getEmail(),
            $userDTO->getPassword(),
            $userDTO->getFullName()
        ]);

        return true;
    }

    public function update(int $id, UserDTO $userDTO): bool
    {
        $this->db->query(
            '
                UPDATE users
                SET 
                  email = ?,
                  password = ?,
                  full_name = ?,
                  is_admin = ?
                WHERE id = ? 
            '
        )->execute([
            $userDTO->getEmail(),
            $userDTO->getPassword(),
            $userDTO->getFullName(),
            $userDTO->getIsAdmin(),
            $id
        ]);

        return true;
    }

    public function delete(int $id): bool
    {
        $this->db->query('DELETE FROM users WHERE id = ?')
            ->execute([$id]);

        return true;
    }

    public function findOneByEmail(string $email): ?UserDTO
    {
        return $this->db->query(
            'SELECT id, 
                    email, 
                    password, 
                    full_name AS fullName,
                    is_admin AS isAdmin
                  FROM users
                  WHERE email = ?
             '
        )->execute([$email])
            ->fetch(UserDTO::class)
            ->current();

    }

    public function findOneById(int $id): ?UserDTO
    {
        return $this->db->query(
            'SELECT id, 
                    email, 
                    password, 
                    full_name AS fullName,
                    is_admin AS isAdmin
                  FROM users
                  WHERE id = ?
             '
        )->execute([$id])
            ->fetch(UserDTO::class)
            ->current();
    }

    /**
     * @return \Generator|UserDTO[]
     */
    public function findAll(): \Generator
    {
        return $this->db->query(
            '
                  SELECT id, 
                      email, 
                      password, 
                      full_name AS fullName,
                      is_admin AS isAdmin
                  FROM users
            '
        )->execute()
            ->fetch(UserDTO::class);
    }

}