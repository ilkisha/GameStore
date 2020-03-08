<?php

namespace App\Service;


use App\Data\UserDTO;
use App\Repository\UserRepositoryInterface;
use App\Service\Encryption\EncryptionServiceInterface;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var EncryptionServiceInterface
     */
    private $encryptionService;

    public function __construct(UserRepositoryInterface $userRepository,
            EncryptionServiceInterface $encryptionService)
    {
        $this->userRepository = $userRepository;
        $this->encryptionService = $encryptionService;
    }

    public function register(UserDTO $userDTO, string $confirmPassword): bool
    {
        if($userDTO->getPassword() !== $confirmPassword){
            return false;
        }

        if(null !== $this->userRepository->findOneByEmail($userDTO->getEmail())){
            return false;
        }

        $this->encryptPassword($userDTO);
        return $this->userRepository->insert($userDTO);
    }

    public function login(string $email, string $password): ?UserDTO
    {
        $userFromDB = $this->userRepository->findOneByEmail($email);

        if(null === $userFromDB){
            return null;
        }

        if(false === $this->encryptionService->verify($password, $userFromDB->getPassword())){
            return null;
        }

        return $userFromDB;
    }

    public function currentUser(): ?UserDTO
    {
        if(!$_SESSION['id']){
            return null;
        }

        return $this->userRepository->findOneById((int)$_SESSION['id']);
    }

    public function isLogged(): bool
    {
        if(!$this->currentUser()){
            return false;
        }
        return true;
    }

    public function edit(UserDTO $userDTO): bool
    {
        if(null !== $this->userRepository->findOneByEmail($userDTO->getEmail())){
            return false;
        }

        $this->encryptPassword($userDTO);
        return $this->userRepository->update((int)$_SESSION['id'], $userDTO);
    }

    /**
     * @return \Generator|UserDTO[]
     */
    public function getAll(): \Generator
    {
       return $this->userRepository->findAll();
    }

    /**
     * @param UserDTO $userDTO
     */
    private function encryptPassword(UserDTO $userDTO): void
    {
        $plainPassword = $userDTO->getPassword();
        $passwordHash = $this->encryptionService->hash($plainPassword);
        $userDTO->setPassword($passwordHash);
    }

}