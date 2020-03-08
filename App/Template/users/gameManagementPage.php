<?php /** @var \App\Data\GameDTO[] $data['games'] */ ?>

<h1>Game Management Page</h1>
<a style="font-weight: bold" href="createGame.php">Create Game</a><br/>
<a style="font-weight: bold" href="home.php">Back</a><br/>
<br/>
<?php if($data['games']->valid()): ?>

    <table border="1">
        <thead>
        <tr>
            <th>Title</th>
            <th>Image URL</th>
            <th>Price</th>
            <th>Description</th>
            <th>Release Date</th>
            <th>Edit Game</th>
            <th>Delete Game</th>

        </tr>
        </thead>
        <form method="post">
            <tbody>
            <?php foreach ($data['games'] as $game): ?>
                <tr>
                    <td><?= $game->getTitle(); ?></td>
                    <td><img src="<?= $game->getImageURL(); ?>" width="200" height="100"/></td>
                    <td><?= $game->getPrice(); ?>$</td>
                    <td><?= $game->getDescription(); ?></td>
                    <td><?= $game->getReleaseDate(); ?></td>
                    <td><a href="editGame.php?id=<?= $game->getId();?>">Edit</a></td>
                    <td><a href="deleteGame.php?id=<?= $game->getId();?>">Delete</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </form>
    </table>
<?php else: ?>
    <h1>No Games available!</h1>
<?php endif; ?>
