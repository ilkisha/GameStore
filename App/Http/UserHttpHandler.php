<?php

namespace App\Http;

use App\Data\ErrorDTO;
use App\Data\UserDTO;
use App\Http\UserHttpHandlerAbstract;
use App\Service\Games\GameServiceInterface;
use App\Service\UserServiceInterface;

class UserHttpHandler extends UserHttpHandlerAbstract
{

    public function index(UserServiceInterface $userService)
    {
        $this->render('home/index');
    }

    public function all(UserServiceInterface $userService){
        $this->render('users/all', $userService->getAll());
    }

    public function home(UserServiceInterface $userService,
                         array $formData = [])
    {
        if(!$userService->isLogged())
        {
            $this->redirect('login.php');
        }

        $currentUser = $userService->currentUser();

        $this->render('users/home', $currentUser);
    }

    public function login(UserServiceInterface $userService,
                          array $formData = [])
    {
        if (isset($formData['login'])) {
            $this->handleLoginProcess($userService, $formData);
        } else {
            $this->render('users/login');
        }
    }

    /**
     * @param UserServiceInterface $userService
     * @param array $formData
     */
    public function register(UserServiceInterface $userService,
                             array $formData = [])
    {
        if (isset($formData['register'])) {
            $this->handleRegisterProcess($userService, $formData);
        } else {
            $this->render('users/register');
        }
    }

    /**
     * @param UserServiceInterface $userService
     * @param $formData
     */
    private function handleRegisterProcess($userService, $formData)
    {
        if ($formData['email'] === '' || $formData['password'] === '' || $formData['confirm_password'] === '' ||
            $formData['full_name'] === '') {
            $this->render('users/register', null,
                [new ErrorDTO('Missing parameters!')]);
            exit;
        }
        try{
            if($formData['password'] !== $formData['confirm_password']){
                $this->render('users/register', null,
                    [new ErrorDTO('Password and confirm password must be same!')]);
                exit;
            }
            $user = $this->dataBinder->bind($formData, UserDTO::class);
            $userService->register($user, $formData['confirm_password']);
            $this->redirect('login.php');
        }catch (\Exception $ex){
            $this->render('users/register', null, [$ex->getMessage()]);
        }
    }

    /**
     * @param $userService
     * @param $formData
     */
    private function handleLoginProcess($userService, $formData)
    {
        /** @var UserServiceInterface $userService */
        $user = $userService->login($formData['email'], $formData['password']);

        $currentUser = $this->dataBinder->bind($formData, UserDTO::class);

        if (null !== $user) {
            $_SESSION['id'] = $user->getId();
            $this->redirect('home.php');
        } else {
            $this->render('users/login', $currentUser,
                new ErrorDTO('Username does not exist or password mismatch.'));
        }

    }

    private function handleEditProcess($userService, $formData)
    {
        /** @var UserServiceInterface $userService */
        $user = $this->dataBinder->bind($formData, UserDTO::class);


        if($userService->edit($user)){
            $this->redirect("home.php");
        }else{
            $this->render("users/login", null,
                new ErrorDTO("Username already exist."));
        }
    }
}