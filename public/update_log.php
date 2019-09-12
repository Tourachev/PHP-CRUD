<?php

/**
 * List all users with a link to edit
 */

require "../config.php";
require "../common.php";

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM log";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>
<div class = "container">
<h2>Update Log</h2>

<table id="dt-select" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
        <th>Game ID</th>
          <th>Server ID</th>
          <th>Player ID</th>
          <th>Date</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
       <td><?php echo escape($row["gameId"]); ?></td>
          <td><?php echo escape($row["serverId"]); ?></td>
          <td><?php echo escape($row["playerId"]); ?></td>
          <td><?php echo escape($row["date"]); ?></td>
            <td><a href="update-single4.php?gameId=<?php echo escape($row["gameId"]); ?>">Edit</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a class="btn btn-primary" href="log.php">Back to home</a>
</div>

<?php require "templates/footer.php"; ?>