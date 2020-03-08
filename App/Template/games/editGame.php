<?php /** @var \App\Data\GameDTO $data */ ?>

<h1>Edit Game</h1>

<a href="gameManagementPage.php">Back</a><br/>

<form method="post">
    Title:        <input type="text" name="title" value="<?= $data->getTitle() ?>"/><br/>
    Image URL:    <input type="text" name="image_url" value="<?= $data->getImageURL() ?>"/><br/>
    Price:        <input type="text" name="price" value="<?= $data->getPrice() ?>"><br/>
    Description:  <textarea rows="5" name="description"><?= $data->getDescription() ?></textarea><br/>
    Release Date: <input type="date" name="release_date" value="<?= $data->getReleaseDate() ?>"/><br/>
    <input type="submit" value="Edit" name="edit"/>
</form>