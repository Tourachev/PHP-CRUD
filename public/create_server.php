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
      "serverId" => $_POST['serverId'],
      "servername"  => $_POST['servername'],
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "server",
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
    <blockquote><?php echo escape($_POST['serverId']); ?> successfully added.</blockquote>
  <?php endif; ?>
  <div class = "container">
  <h2>Add a server</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="serverId">Server ID </label>
    <input type="text" name="serverId" id="serverId">
    <label for="servername">Server name</label>
    <input type="text" name="servername" id="servername">
    <input type="submit" name="submit" value="Submit">
  </form>


  <a class="btn btn-primary" href="servers.php">Back to home</a>
  </div>

<?php require "templates/footer.php"; ?>
