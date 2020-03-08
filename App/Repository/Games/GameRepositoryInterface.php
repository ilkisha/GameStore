<?php

namespace App\Repository\Games;

use App\Data\GameDTO;
use Generator;

interface GameRepositoryInterface
{
    public function insert(GameDTO $gameDTO) : bool;
    public function update(GameDTO $gameDTO, int $id) : bool;
    public function remove(int $id) : bool;
    public function insertToShoppingCart(int $userId, int $gameId) : bool;
    public function removeFromCart(int $userId, int $gameId) : bool;
    public function checkGameExistInCart(int $userId, int $gameId) : Generator;
    public function getAllShoppingCartGames(int $userId) : Generator;
    public function insertIntoOwnedGames(int $userId, int $gameId): bool;
    public function deleteAllShoppingCartGames(int $userId): bool;
    public function checkExistOwnedGames(int $userId, int $gameId) : Generator;
    public function allMyGames(int $userId) : Generator;
    public function checkUrlIdExistOrValid(string $id) : Generator;

    /**
     * @param int $userId
     * @return Generator|GameDTO[]
     */
    public function findMyShoppingCartGames(int $userId) : \Generator;

    /**
     * @return Generator|GameDTO[]
     */
    public function findAll() : Generator;

    public function findOneById(int $id) : ?GameDTO;
}