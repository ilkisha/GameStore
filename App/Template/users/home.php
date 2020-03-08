<?php /** @var \App\Data\UserDTO $data  */ ?>

<h1>Hello, <?= $data->getFullName() ?></h1>
<h3><a href="allGames.php">All Games</a></h3>
<h3><a href="ownedGames.php">Owned Games</a></h3>
<h3><a href="myShoppingCart.php">My Shopping Cart</a></h3>

<?php
if($data->getIsAdmin() === '1'){
    echo '<h3><a href="gameManagementPage.php">Game Management Page</a></h3>';
}
?>

<br/>
<a href="logout.php">Logout</a>