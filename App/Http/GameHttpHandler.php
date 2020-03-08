<?php

namespace App\Http;

use App\Data\ErrorDTO;
use App\Data\GameDTO;
use App\Data\UserDTO;
use App\Service\Games\GameServiceInterface;
use App\Service\UserServiceInterface;
use Core\DataBinderInterface;
use Core\TemplateInterface;

class GameHttpHandler extends UserHttpHandlerAbstract
{
    /**
     * @var GameServiceInterface
     */
    private $gameService;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    public function __construct(
        TemplateInterface $template,
        DataBinderInterface $dataBinder,
        GameServiceInterface $gameService,
        UserServiceInterface $userService)
    {
        parent::__construct($template, $dataBinder);
        $this->gameService = $gameService;
        $this->userService = $userService;
    }


    public function add(array $formData = [])
    {
        /**
         * @var UserDTO $user
         */
        $user = $this->userService->currentUser();

        if(!$this->userService->isLogged()) {
            $this->redirect('login.php');
            exit;
        }

        if($user->getIsAdmin() === 0){
            $this->redirect('home.php');
            exit;
        }

        if(isset($formData['create'])){
            $this->handleCreateProcess($formData);
        }else{
            $this->render('games/create');
        }
    }

    private function handleCreateProcess(array $formData)
    {
        try{
            if($formData['title'] === '' || $formData['image_url'] === '' || $formData['price'] === ''
                || $formData['description'] === '' || $formData['release_date'] === ''){
                $this->render('games/create', null, [new ErrorDTO('
                Missing data fields')]);
                exit;
            }

            $price = (float)$formData['price'];

            if($price == 0){
                $this->render('games/create', null, [new ErrorDTO('Invalid Price!')]);
                exit;
            }
            /**
             * @var GameDTO $game
             */
            $game = $this->dataBinder->bind($formData, GameDTO::class);
            $game->setPrice($price);
            $this->gameService->add($game);
            $this->redirect('gameManagementPage.php');
        }catch (\Exception $ex){
            echo $ex->getMessage();
        }
    }

    public function allGames()
    {
        if(!$this->userService->isLogged()){
            $this->redirect('login.php');
            exit;
        }

        $allGames = $this->gameService->getAll();
        $data['games'] = $allGames;
        $this->render('games/allGames', $data);
    }

    public function view($getData = [])
    {
        if(!$this->userService->isLogged()){
            $this->redirect('login.php');
            exit;
        }

        if(!($this->gameService->checkUrlIdExistOrValid((int)$getData['id'])->valid())){
            $this->redirect('allGames   .php');
            exit;
        }

        $game = $this->gameService->getOneById($getData['id']);
        $data['game'] = $game;
        $this->render('games/view', $data);
    }

    public function delete(array $getData = [])
    {
        if(!$this->userService->isLogged()){
            $this->redirect('login.php');
            exit;
        }

        if($this->userService->currentUser()->getIsAdmin() === '0'){
            $this->redirect('home.php');
            exit;
        }

        $this->gameService->delete($getData['id']);
        $this->redirect('gameManagementPage.php');
    }

    public function edit($formData = [], $getData = [])
    {
        if(!$this->userService->isLogged()) {
            $this->redirect('login.php');
            exit;
        }

        if($this->userService->currentUser()->getIsAdmin() === '0'){
            $this->redirect('allBooks.php');
            exit;
        }

        if(isset($formData['edit'])){
            /** @var GameDTO $game */
            $game = $this->dataBinder->bind($formData, GameDTO::class);
            $game->setId((int)$getData['id']);
            $game->setPrice(((float)$formData['price']));
            $this->gameService->edit($game, (int)$getData['id']);
            $this->redirect('gameManagementPage.php');
        }else{
            $game = $this->gameService->getOneById($getData['id']);
            $this->render('games/editGame', $game);
        }
    }

    public function addToShoppingCart($getData = [])
    {
        if(!$this->userService->isLogged()){
            $this->redirect('login.php');
            exit;
        }

        $gameId = (int)$getData['id'];
        $userId = (int)$this->userService->currentUser()->getId();

        if(null === $this->gameService->checkGameExistInCart($userId, $gameId)->current() &&
            null === $this->gameService->checkExistOwnedGames($userId, $gameId)->current()){
            $this->gameService->addToShoppingCart($userId, $gameId);
            $this->redirect('myShoppingCart.php');
            return;
        }

        $this->redirect('allGames.php');
    }

    public function myShoppingCartGames()
    {
        if(!$this->userService->isLogged()) {
            $this->redirect('login.php');
            exit;
        }

        $userId = (int)$this->userService->currentUser()->getId();
        $allGames = $this->gameService->myShoppingCart($userId);

        $games = [];

        foreach ($allGames as $currGame){
            $games[] = $this->gameService->getOneById((int)$currGame['game_id']);
        }

        $data['games'] = $games;

        $this->render('games/myShoppingCart', $data);
    }

    public function removeGame($getData = [])
    {
        if(!$this->userService->isLogged()){
            $this->redirect('login.php');
            exit;
        }

        $gameId = (int)$getData['id'];
        $userId = (int)$this->userService->currentUser()->getId();

        $this->gameService->deleteFromShoppingCart($userId, $gameId);

        $this->redirect('myShoppingCart.php');
    }

    public function buyGames()
    {
        if(!$this->userService->isLogged()) {
            $this->redirect('login.php');
            exit;
        }

        $userId = (int)$this->userService->currentUser()->getId();

        $gamesFromShoppingCart = $this->gameService->getShoppingCartGames($userId);

        foreach ($gamesFromShoppingCart as $game) {
            $this->gameService->addIntoOwnedGames((int)$game['user_id'], (int)$game['game_id']);
        }
        $this->gameService->deleteAllShoppingCartGames($userId);

        $this->redirect('ownedGames.php');
    }

    public function ownedGames()
    {
        if(!$this->userService->isLogged()) {
            $this->redirect('login.php');
            exit;
        }

        $userId = (int)$this->userService->currentUser()->getId();

        $ownedGames = $this->gameService->allMyGames($userId);

        $ownedGamesForTemplate = [];

        foreach ($ownedGames as $game) {
            $ownedGamesForTemplate[] = $this->gameService->getOneById((int)$game['game_id']);
        }
        $data['games'] = $ownedGamesForTemplate;

        $this->render('games/ownedGames', $data);
    }

    public function adminGameManagement()
    {
        if(!$this->userService->isLogged()){
            $this->redirect('login.php');
            exit;
        }

        if($this->userService->currentUser()->getIsAdmin() === '0'){
            $this->redirect('home.php');
            exit;
        }

        $allGames = $this->gameService->getAll();
        $data['games'] = $allGames;
        $this->render('users/gameManagementPage', $data);
    }
}