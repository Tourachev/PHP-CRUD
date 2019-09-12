<?php

/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * 
            FROM server
            WHERE serverId = :serverId";

    $serverId = $_POST['serverId'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':serverId', $serverId, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>

<?php require "templates/header.php"; ?>
        
<?php  
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <div class = "container">
    <h2>Results</h2>

    <table id="dt-select" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr>
        <th>Server ID</th>
          <th>Server Name</th>
        </tr>
      </thead>
      <tbody>
      </div>
      <?php foreach ($result as $row) : ?>
        <tr>
        <td><?php echo escape($row["serverId"]); ?></td>
          <td><?php echo escape($row["servername"]); ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found for <?php echo escape($_POST['serverId']); ?>.</blockquote>
    <?php } 
} ?> 
<div class = "container">
<h2>Find server based on server ID: </h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="serverId">Server ID</label>
  <input type="text" id="serverId" name="serverId">
  <input type="submit" name="submit" value="View Results">
</form>


<a class="btn btn-primary" href="servers.php">Back to home</a>
</div>
<?php require "templates/footer.php"; ?>