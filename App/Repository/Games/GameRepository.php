<?php


namespace App\Repository\Games;


use App\Data\GameDTO;
use App\Repository\DatabaseAbstract;
use Generator;

class GameRepository extends DatabaseAbstract implements GameRepositoryInterface
{

    public function insert(GameDTO $gameDTO): bool
    {
        $this->db->query('
                INSERT INTO games(
                    title, 
                    image_url, 
                    price,
                    description,
                    release_date)
                VALUES (?, ?, ?, ?, ?)
        ')->execute([
            $gameDTO->getTitle(),
            $gameDTO->getImageURL(),
            $gameDTO->getPrice(),
            $gameDTO->getDescription(),
            $gameDTO->getReleaseDate()
        ]);

        return true;
    }

    public function update(GameDTO $gameDTO, int $id): bool
    {
        $this->db->query('
                UPDATE games
                SET
                    title = ?,
                    image_url = ?,
                    price = ?,
                    description = ?,
                    release_date = ?
                WHERE id = ?
        ')->execute([
            $gameDTO->getTitle(),
            $gameDTO->getImageURL(),
            $gameDTO->getPrice(),
            $gameDTO->getDescription(),
            $gameDTO->getReleaseDate(),
            $id
        ]);

        return true;
    }

    public function remove(int $id): bool
    {
        $this->db->query('DELETE FROM games WHERE id = ?')
            ->execute([$id]);

        return true;
    }


    /**
     * @return Generator|GameDTO[]
     */
    public function findAll(): Generator
    {
        return $this->db->query(
            '
                  SELECT id, 
                      title,
                      image_url as imageURL, 
                      price,
                      description,
                      release_date AS releaseDate
                  FROM games
            '
        )->execute()
            ->fetch(GameDTO::class);
    }

    public function findOneById(int $id): ?GameDTO
    {
        return $this->db->query(
            'SELECT id, 
                    title,
                    image_url as imageURL, 
                    price,
                    description,
                    release_date AS releaseDate
                  FROM games
                  WHERE id = ?
             '
        )->execute([$id])
            ->fetch(GameDTO::class)
            ->current();
    }

    public function insertToShoppingCart(int $userId, int $gameId): bool
    {
        $this->db->query(
            'INSERT INTO shopping_cart(
                          user_id,
                          game_id)
                    VALUES(?, ?)'
        )->execute([$userId, $gameId]);

        return true;
    }

    /**
     * @param int $userId
     * @return Generator|GameDTO[]
     */
    public function findMyShoppingCartGames(int $userId) : \Generator
    {
        return $this->db->query(
            'SELECT 
                        user_id,
                        game_id
                  FROM shopping_cart
                  WHERE user_id = ?
             '
        )->execute([$userId])
            ->fetchAssoc();

    }

    public function removeFromCart(int $userId, int $gameId): bool
    {
        $this->db->query('DELETE FROM shopping_cart
                                WHERE user_id = ? AND game_id = ?
       ')->execute([$userId, $gameId]);

        return true;
    }

    public function checkGameExistInCart(int $userId, int $gameId): Generator
    {
        return $this->db->query(
            'SELECT 
                        user_id, 
                        game_id
                    FROM shopping_cart
                    WHERE user_id = ? AND game_id = ?;
            '
        )->execute([$userId, $gameId])->fetchAssoc();
    }

    public function getAllShoppingCartGames(int $userId): Generator
    {
        return $this->db->query(
            'SELECT * FROM shopping_cart
                    WHERE user_id = ?'
        )->execute([$userId])
            ->fetchAssoc();
    }

    public function deleteAllShoppingCartGames(int $userId): bool
    {
        $this->db->query('
                    DELETE FROM shopping_cart 
                    WHERE user_id = ?')
            ->execute([$userId]);
        return true;
    }

    public function insertIntoOwnedGames(int $userId, int $gameId): bool
    {
        $this->db->query(
            'INSERT INTO owned_games(
                          user_id,
                          game_id)
                    VALUES(?, ?)'
        )->execute([$userId, $gameId]);

        return true;
    }

    public function checkExistOwnedGames(int $userId, int $gameId): Generator
    {
        return $this->db->query(
            'SELECT 
                        user_id, 
                        game_id
                    FROM owned_games
                    WHERE user_id = ? AND game_id = ?;
            '
        )->execute([$userId, $gameId])->fetchAssoc();
    }

    public function allMyGames(int $userId): Generator
    {
        return $this->db->query(
            'SELECT 
                        user_id,
                        game_id
                  FROM owned_games
                  WHERE user_id = ?
             '
        )->execute([$userId])
            ->fetchAssoc();
    }

    public function checkUrlIdExistOrValid(string $id): Generator
    {
        return $this->db->query(
            'SELECT * FROM games WHERE id = ?'
        )->execute([$id])->fetchAssoc();
    }
}