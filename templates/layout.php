<?php



class layout

{

	

public static function pageTop($title)

{ 



echo <<<pageTop

<!DOCTYPE html>

<html>

<head>

<title>Grab & Go</title>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">

<style>

body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}

</style>

<style>

#wrapper{

	margin:auto;

	width:800px;

}

label{display:block}



</style>

<head>

 <body>



    <div id ="container">

	   

    <ul class="w3-navbar w3-border w3-light-grey">

  <li><a href="index.php">Home</a></li>

  <li><a href="new_Post.php">Create New Post</a></li>

 <li><a href="login.php">login</a></li>

  <li><a href="logout.php">Log Out</a></li>

  <li><a href="viewpage.php">viewpage</a></li>

  <li><a href="admin.php">Create New User</a></li>

            </ul>

        </div>

<div id ="container">



<!-- Header -->

<header class="w3-container w3-center w3-padding-32"> 

  <h1><b>Grab & Go</b></h1>



</header>

 <!-- Image header -->

  <header class="w3-display-container w3-wide" id="home">

    <img src="/public/asset/img/diamond.png" width="1400" height="300" align="middle">

    <div class="w3-display-left w3-padding-xlarge">

      <h1 class="w3-text-black">Trizzle's</h1>

      <h1 class="w3-jumbo w3-text-black w3-hide-small"><b>Diamond BLOG</b></h1>

    </div>

  </header>

	

pageTop;



}

public static function pageBottom()

{ 



echo <<<pageBottom

</div>

<footer class="w3-container w3-dark-grey w3-padding-32 w3-margin-top">

  

  <p>471 washington street</a></p>

  <p>Leetsdale, Pa 15056 <a/></p>



</body>

</html>

}

pageBottom;



}

}

?>