<?php /** @var \App\Data\ErrorDTO $errors */ ?>

<h1>Create New Game</h1>

<h2><a href="gameManagementPage.php">Manage Games</a></h2><br/>
<?php if(count($errors) !== 0){
    echo '<h2 style="color: red">' . $errors[0]->getMessage() . '</h2>';
} ?>

<form method="post">
    Title:        <input type="text" name="title"/><br/>
    Image URL:    <input type="text" name="image_url"/><br/>
    Price:        <input type="text" name="price"><br/>
    Description:  <textarea rows="5" name="description"></textarea><br/>
    Release Date: <input type="date" name="release_date"/>
    <input type="submit" value="Create" name="create"/>
</form>