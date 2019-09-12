<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $new_user = array(
      "gameId" => $_POST['gameId'],
      "description"  => $_POST['description'],
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "game",
      implode(", ", array_keys($new_user)),
      ":" . implode(", :", array_keys($new_user))
    );
    
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['gameId']); ?> successfully added.</blockquote>
  <?php endif; ?>
  <div class = "container">
  <h2>Add a game</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="gameId">Game ID</label>
    <input type="text" name="gameId" id="gameId">
    <label for="description">Description</label>
    <input type="text" name="description" id="description">

    <input type="submit" name="submit" value="Submit">
  </form>

  <a class="btn btn-primary" href="games.php">Back to home</a>
  </div>

<?php require "templates/footer.php"; ?>
