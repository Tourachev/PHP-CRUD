<?php

/**
 * List all users with a link to edit
 */

require "../config.php";
require "../common.php";

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
<h2>Update player</h2>

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
            <td><a href="update-single1.php?playerId=<?php echo escape($row["playerId"]); ?>">Edit</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a class="btn btn-primary" href="players.php">Back to home</a>
</div>

<?php require "templates/footer.php"; ?>