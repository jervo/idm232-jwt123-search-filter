<!DOCTYPE html>

<html>

<head>
  <title>PHP Main Menu Dynamic</title>
  <link rel="stylesheet" href="./styles/general.css">
</head>

<body>

  <?php
    // $msg = "HOWDY";
    // echo '<script type="text/javascript">console.log("'. $msg .'");</script>';

    require_once './includes/fun.php';
    consoleMsg("PHP to JS .. is Wicked FUN");

    // Include env.php that holds global vars with secret info
    require_once './env.php';

    // Include the database connection code
    require_once './includes/database.php';

  ?>

  <h1>PHP Main Menu Dynamic</h1>

  <!-- STEP 04 Build Search FORM -->
  <form action="index.php" method="POST">
    <label for="search">Search:</label>
    <input type="search" id="search" name="search" value="<?php echoSearchValue(); ?>">
    <button type="submit" name="submit" value="submit">Submit</button>
  </form>

  <ul id="filters">
    <li><a href="index.php?filter=beef">BEEF</a></li>
    <li><a href="index.php?filter=chicken">CHICKEN</a></li>
    <li><a href="index.php?filter=pork">PORK</a></li>
    <li><a href="index.php?filter=vegitarian">VEGETARIAN</a></li>
  </ul>

  <div id="content">
    <?php
      // // Get all the recipes from "recipes" table in the "idm232" database
      // $query = "SELECT * FROM recipes";

      // STEP 05 Build Search Query
      $search = $_POST['search'];
      consoleMsg("Search is: $search");

      // STEP 06 Build Filter Query
      // Get filter info if passed in URL
      $filter = $_GET['filter'];
      consoleMsg("Filter is: $filter");

      if (!empty($search)) {
        consoleMsg("Doing a SEARCH");
        // $query = "select * FROM recipes WHERE title LIKE '%{$search}%'";
        $query = "select * FROM recipes WHERE title LIKE '%{$search}%' OR subtitle LIKE '%{$search}%'";
        $result = mysqli_query($connection, $query);
      } elseif (!empty($filter)) {
        consoleMsg("Doing a FILTER");
        $query = "select * FROM recipes WHERE proteine LIKE '%{$filter}%'";
      } else {
        consoleMsg("Loading ALL RECIPES");
        $query = "SELECT * FROM recipes";
      }

      $results = mysqli_query($db_connection, $query);
      if ($results->num_rows > 0) {
        consoleMsg("Query successful! number of rows: $results->num_rows");
        while ($oneRecipe = mysqli_fetch_array($results)) {
          
          $id = $oneRecipe['id'];

          // STEP 01 .. Wrap thumbnail in anchor tag
          echo '<a href="./detail.php?recID='. $id .'">';

            if ($id % 2 == 0) {
              echo '<figure class="oneRec">';
            } else {
              echo '<figure class="oneRecOdd">';
            }
            echo '<img src="./images/' . $oneRecipe['Main IMG'] . '" alt="Dish Image">';
            echo '<figcaption>' . $id . ' ' . $oneRecipe['Title'] . '</figcaption>';
            echo '</figure>';

          // STEP 02 .. Close anchor tag
          echo '</a>';
        }

      } else {
        consoleMsg("QUERY ERROR");
      }
    ?>

  </div>

</body>

</html>