<?php include "templates/header.php"; ?>

 <div class = "container">
    <div class="jumbotron">
        <h1 class="display-4">Appointments.</h1>
        <p class="lead"></p>
        <hr class="my-4">
        <p>Come on time, wait an hour.</p>
    </div>
    <div class="btn-group btn-group-justified">
		<a href="create_server.php"class="btn btn-primary"><strong>  Create  </strong></a>
		<a href="read_server.php"class="btn btn-primary"><strong>  Read  </strong></a>
		<a href="update_server.php"class="btn btn-primary"><strong>  Update  </strong></a>
		<a href="delete_server.php"class="btn btn-primary"><strong>  Delete  </strong></a>

	</div>

	<br>
  <br>
  <?php
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * 
            FROM server";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':serverId', $serverId, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
    ?>

    <table id="dt-select" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>Server ID</th>
          <th>Server name</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["serverId"]); ?></td>
          <td><?php echo escape($row["servername"]); ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <br>
    <br>
    <br>
</div>

<?php include "templates/footer.php"; ?>