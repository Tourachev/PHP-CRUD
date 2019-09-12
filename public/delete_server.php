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
  
    $patientNum = $_POST["submit"];

    $sql = "DELETE FROM server WHERE serverId = :serverId";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':serverId', $patientNum);
    $statement->execute();

    $success = "Server successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM server";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>
<div class = "container">
<h2>Delete server</h2>

<?php if ($success) echo $success; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <table id="dt-select" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
      <tr>
          <th>Server ID</th>
          <th>Server Name</th>
      </tr>
    </thead>
    <tbody>

    <?php foreach ($result as $row) : ?>
      <tr>
      <td><?php echo escape($row["serverId"]); ?></td>
          <td><?php echo escape($row["servername"]); ?></td>
        <td><button type="submit" name="submit" value="<?php echo escape($row["serverId"]); ?>">Delete</button></td>
      </tr>
    <?php endforeach; ?>

    </tbody>
  </table>
</form>

<a class="btn btn-primary" href="servers.php">Back to home</a>
</div>
<?php require "templates/footer.php"; ?>