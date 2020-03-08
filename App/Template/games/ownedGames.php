<?php /** @var \App\Data\GameDTO[] $data['games'] */ ?>

    <h1>Recently bought games</h1>
    <h3><a href="home.php">Back</a><br/></h3>
    <a href="logout.php">Logout</a>
    <br/> <br/>

<?php if(count($data['games']) !== 0): ?>

    <table border="1">
        <thead>
        <tr>
            <th>Title</th>
            <th>Image URL</th>
            <th>Price</th>
            <th>Description</th>
            <th>Release Date</th>
            <th>View</th>

        </tr>
        </thead>
        <form method="post">
            <tbody>
            <?php foreach ($data['games'] as $game): ?>
                <tr>
                    <td><?= $game->getTitle(); ?></td>
                    <td><img src="<?= $game->getImageURL(); ?>" width="200" height="100"/></td>
                    <td><?= $game->getPrice(); ?></td>
                    <td><?= $game->getDescription(); ?></td>
                    <td><?= $game->getReleaseDate(); ?></td>
                    <td><a href="viewGame.php?id=<?= $game->getId();?>">View Game</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </form>
    </table>
<?php else: ?>
    <h1>No games available!</h1>
<?php endif; ?>