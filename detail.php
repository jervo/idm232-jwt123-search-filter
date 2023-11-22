<!DOCTYPE html>

<html>

<head>
  <title>PHP Recipe Detail Dynamic</title>
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

  <h1>PHP Recipe Detail Dynamic</h1>

  <div id="content">

    <?php
      // // Get all the recipes from "recipes" table in the "idm232" database
      // $query = "SELECT * FROM recipes WHERE id=23";

      // STEP 03 Get the ID number passed to this page
      $recID = $_GET['recID'];
      $query = "SELECT * FROM recipes WHERE id={$recID}";

      $results = mysqli_query($db_connection, $query);
      if ($results->num_rows > 0) {
        consoleMsg("Query successful! number of rows: $results->num_rows");
        while ($oneRecipe = mysqli_fetch_array($results)) {

          //TITLE
          echo '<h3> Title: ' .$oneRecipe['Title']. '</h3>'; 
          // SUBTITLE
          echo '<h3> Subtitle: ' .$oneRecipe['Subtitle']. '</h3>'; 

          // HERO IMAGE
          echo '<figure class="oneRec">';
          echo '<img src="./images/' . $oneRecipe['Main IMG'] . '" alt="Dish Image">';
          echo '</figure>';

          // COOKTIME
          
          // SERVINGS
          
          // NUTRITION
          echo '<h3> Calories Per Serving: ' . $oneRecipe['Cal/Serving']  .  '</h3>'; 
          
          // DESCRIPTION
          echo '<p> Description: ' . $oneRecipe['Description']  .  '</p>'; 
          
          // INGREDIENTS IMAGE
          echo '<p><img src="./images/' . $oneRecipe['Ingredients IMG'] . '" alt="Dish Image"></p>';
          
          // INGREDIENTS BUllET LIST
          echo '<p> Ingredients: ' . $oneRecipe['All Ingredients']  .  '</p>'; 
          
          // CONVERT INGREDIENTS STRING INTO ARRAY
          $ingredientsArray = explode("*", $oneRecipe['All Ingredients']);
          echo '<p> Ingredients Array: ' . $ingredientsArray[1]  .  '</p>'; 

          // LOOP THRU INGREDIENTS ARRAY
          echo '<ul>';
          for($lp = 0; $lp < count($ingredientsArray); $lp++) {
            echo '<li>' . $ingredientsArray[$lp] . '</li>';
          }
          echo '<ul>';

          // INSTRUCTIONS STEP TEXT
          // INSTRUCTIONS STEP IMAGE


          $stepTextArray = explode("*", $oneRecipe['All Steps']);
          echo '<p> Number of Step Text: ' . count($stepTextArray) . '</p>';
          
          $stepImagesArray = explode("*", $oneRecipe['Step IMGs']);
          echo '<p> Number of Step Images: ' . count($stepImagesArray) . '</p>';   

          for($lp = 0; $lp < count($stepTextArray); $lp++) {
            // If step starts with a number, get number minus one for image name
            $firstChar = substr($stepTextArray[$lp],0,1);
            if (is_numeric($firstChar)) {
              consoleMsg("First Char is: $firstChar");
              echo '<img src="./images/' . $stepImagesArray[$firstChar-1] . '" alt="Step Image">';
            }
            echo '<p>' . $stepTextArray[$lp] . '</p>';
          }
        }

      } else {
        consoleMsg("QUERY ERROR");
      }
    ?>


  </div>

</body>

</html>