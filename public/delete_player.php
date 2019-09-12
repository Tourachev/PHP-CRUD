<?php

/**
 * Delete a user
 */

require "../config.php";
require "../common.php";

$success = null;

if (isset($_POST["submit"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);
  
    $playerId = $_POST["submit"];

    $sql = "DELETE FROM playerProfile WHERE playerId = :playerId";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':playerId', $playerId);
    $statement->execute();

    $success = "User successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM playerProfile";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>
<div class = "container">
<h2>Delete player</h2>

<?php if ($success) echo $success; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <table id="dt-select" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
      <tr>
          <th>Player ID</th>
          <th>Username</th>
      </tr>
    </thead>
    <tbody>

    <?php foreach ($result as $row) : ?>
      <tr>
          <td><?php echo escape($row["playerId"]); ?></td>
          <td><?php echo escape($row["username"]); ?></td>
        <td><button type="submit" name="submit" value="<?php echo escape($row["playerId"]); ?>">Delete</button></td>
      </tr>
    <?php endforeach; ?>

    </tbody>
  </table>
</form>

<a class="btn btn-primary" href="players.php">Back to home</a>
</div>
<?php require "templates/footer.php"; ?>