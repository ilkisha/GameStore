<?php


namespace App\Service\Games;


use App\Data\GameDTO;
use App\Repository\Games\GameRepositoryInterface;
use App\Service\UserServiceInterface;
use Generator;

class GameService implements GameServiceInterface
{

    /**
     * @var GameRepositoryInterface
     */
    private $gameRepository;

    /**
     * @var UserServiceInterface
     */
    private $userService;


    public function __construct(GameRepositoryInterface $gameRepository, UserServiceInterface $userService)
    {
        $this->gameRepository = $gameRepository;
        $this->userService = $userService;
    }


    public function add(GameDTO $gameDTO): bool
    {
        return $this->gameRepository->insert($gameDTO);
    }

    public function edit(GameDTO $gameDTO, int $id): bool
    {
        return $this->gameRepository->update($gameDTO, $gameDTO->getId());
    }

    public function delete(int $id): bool
    {
        return $this->gameRepository->remove($id);
    }

    /**
     * @inheritDoc
     */
    public function getAll(): \Generator
    {
        return $this->gameRepository->findAll();
    }

    public function getOneById(int $id): GameDTO
    {
        return $this->gameRepository->findOneById($id);
    }

    public function addToShoppingCart(int $userId, int $gameId): bool
    {
        return $this->gameRepository->insertToShoppingCart($userId, $gameId);
    }

    public function myShoppingCart(int $userId): \Generator
    {
        return $this->gameRepository->findMyShoppingCartGames($userId);
    }

    public function deleteFromShoppingCart(int $userId, int $gameId): bool
    {
        return $this->gameRepository->removeFromCart($userId, $gameId);
    }

    public function checkGameExistInCart(int $userId, int $gameId): \Generator
    {
        return $this->gameRepository->checkGameExistInCart($userId, $gameId);
    }

    public function getShoppingCartGames(int $userId): \Generator
    {
        return $this->gameRepository->getAllShoppingCartGames($userId);
    }

    public function addIntoOwnedGames(int $userId, int $gameId): bool
    {
        return $this->gameRepository->insertIntoOwnedGames($userId, $gameId);
    }

    public function deleteAllShoppingCartGames(int $userId): bool
    {
        return $this->gameRepository->deleteAllShoppingCartGames($userId);
    }

    public function checkExistOwnedGames(int $userId, int $gameId): \Generator
    {
        return $this->gameRepository->checkExistOwnedGames($userId, $gameId);
    }

    public function allMyGames(int $userId): Generator
    {
        return $this->gameRepository->allMyGames($userId);
    }

    public function checkUrlIdExistOrValid(int $urlId): \Generator
    {
        return $this->gameRepository->checkUrlIdExistOrValid($urlId);
    }
}