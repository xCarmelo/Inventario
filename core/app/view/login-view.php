<?php

if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]!=""){
		print "<script>window.location='index.php?view=home';</script>";
} 

?>

<div class="login-container">
  <div class="login-form">
    <img src="your-image.jpg" alt="Login Image">
    <h2>Welcome</h2>
    <form action="index.php?view=processlogin" method="post">
      <label for="username">Username:</label>
      <input type="text" id="username" name="mail" required>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
      <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="#">Create Account</a></p>
  </div>
</div>