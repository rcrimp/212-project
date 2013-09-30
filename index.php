<!DOCTYPE html>
<html>
  <head>
    <title>Walrus Forum Portal</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/default.css">
    <link rel="stylesheet" href="style/portal.css">
    <link rel="icon" href="images/favicon.png">
    
    <script src="scripts/jquery.js"></script>
    <script src="scripts/cookie.js"></script>
    <script src="scripts/portal.js"></script>
  </head>
  <body>
    <header><img id="logo" src="images/logo_b.png" alt="Forum logo">
      <h1>Walrus Forum Portal</h1>
    </header>

    <div id="main">
      <button id="lbutton"><h2>Login</h2></button>
      <form id="loginform" name="loginform" action="login.php" method="POST">
        <label for="loginuser">Username </label>
        <input id="loginuser" type="text" name="user">
        <label for="loginpass">Password </label>
        <input id="loginpass" type="password" name="pass">
        <input class="submit" type="submit" value="login">
      </form>

      <button id="rbutton"><h2>Regsiter</h2></button>
      <form id="registerform" name="registerform" action="register.php" method="POST">

        <label for="reguser">Username
          <span class="small">Desired user name</span>
        </label>
        <input id="reguser" type="text" name="user" maxlength="20">

        <label for="regfname">Name
          <span class="small">Your first name</span>
        </label>
        <input id="regfname" type="text" name="fname">

        <label for="reglname">Surname
          <span class="small">Your last name</span>
        </label>
        <input id="reglname" type="text" name="lname">

        <label for="reggender">Gender
          <span class="small">Your own gender</span>
        </label>
        <select id="reggender" name="gender">
          <option value="">Prefer not to say</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
        
        <label for="regpass">Password
          <span class="small">Min. size 6 chars</span>
        </label>
        <input id="regpass" type="password" name="pass">

        <label for="regpass2">Password
          <span class="small">Type again</span>
        </label>
        <input id="regpass2" type="password" name="pass2">

        <label for="regemail">email
          <span class="small">A valid email address</span>
        </label>
        <input id="regemail" type="text" name="email">

        <input class="submit" type="submit" value="register">
      </form>
    </div>
    
    <footer><p>Reuben Crimp © 2013</p></footer>
  </body>
</html>
