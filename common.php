<?php

session_start();
spl_autoload_register();

$template = new \Core\Template();
$dataBinder = new \Core\DataBinder();
$dbInfo = parse_ini_file('Config/db.ini');
$pdo = new PDO($dbInfo['dsn'], $dbInfo['user'], $dbInfo['pass']);
$db = new \Database\PDODatabase($pdo);
$userRepository = new \App\Repository\UserRepository($db, $dataBinder);
$gameRepository = new \App\Repository\Games\GameRepository($db, $dataBinder);
$encryptionService = new \App\Service\Encryption\ArgonEncryptionService();
$userService = new \App\Service\UserService($userRepository, $encryptionService);
$gameService = new \App\Service\Games\GameService($gameRepository, $userService);
$userHttpHandler = new \App\Http\UserHttpHandler($template, $dataBinder);
$gameHttpHandler = new \App\Http\GameHttpHandler($template, $dataBinder, $gameService, $userService);