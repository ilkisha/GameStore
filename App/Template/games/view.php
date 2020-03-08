
<?php /** @var \App\Data\GameDTO $data['game']*/ ?>

<h1>View Game</h1>

<h3><a href="allGames.php">Back</a><br/></h3>

<p><b>Title:</b> <?= $data['game']->getTitle(); ?> </p>
<p><b>Description:</b> <?= $data['game']->getDescription(); ?> </p>
<p><b>Release Date:</b> <?= $data['game']->getReleaseDate(); ?> </p>
<p><b>Price:</b> <?= $data['game']->getPrice(); ?> </p>
<img src="<?= $data['game']->getImageURL(); ?>" alt="None" width="200" height="300"/>
<br/>
<a href="buyGame.php">Buy</a>


