<?php


namespace App\Service\Games;


use App\Data\GameDTO;
use Generator;

interface GameServiceInterface
{
    public function add(GameDTO $gameDTO) : bool;
    public function edit(GameDTO $gameDTO, int $id) : bool;
    public function delete(int $id) : bool;
    public function addToShoppingCart(int $userId, int $gameId): bool;
    public function myShoppingCart(int $userId) : \Generator;
    public function deleteFromShoppingCart(int $userId, int $gameId) : bool;
    public function checkGameExistInCart(int $userId, int $gameId) : \Generator;
    public function getShoppingCartGames(int $userId) : \Generator;
    public function addIntoOwnedGames(int $userId, int $gameId): bool;
    public function deleteAllShoppingCartGames(int $userId): bool;
    public function checkExistOwnedGames(int $userId, int $gameId) : \Generator;
    public function allMyGames(int $userId) : Generator;
    public function checkUrlIdExistOrValid(int $urlId) : \Generator;

    /**
     * @return \Generator|GameDTO[]
     */
    public function getAll() : \Generator;
    public function getOneById(int $id) : GameDTO;
}