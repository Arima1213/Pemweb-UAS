<?php
session_start();

// Check if user is already logged in
if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  if ($username == "admin" && $password == "admin123") {
    $_SESSION['username'] = $username;
    $_SESSION['nama'] = $username;
    header('Location: admin.php');
    exit();
  } else {
    require_once "koneksi.php";

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);

    // Execute the SQL statement
    if (!$stmt->execute()) {
      die("Execution failed: " . $stmt->error);
    }

    // Get the result of the SQL statement
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $stmt->bind_result($hashed_password);
      $stmt->fetch();

      if ($password == $hashed_password) {
        $_SESSION['username'] = $username;
        $_SESSION['nama'] = $nama;
        $_SESSION['user_id'] = $user_id;

        header('Location: index.php');
        exit();
      } else {
        $error_message = "Invalid password $hashed_password $password";
      }
    } else {
      $error_message = "Invalid username or password";
    }
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/loginstyle.css" />
  <title>Document</title>
  <style>
    .login-page {
      position: relative;
    }

    .login-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      /* From https://css.glass */
      border-radius: 16px;
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(4.9px);
      -webkit-backdrop-filter: blur(4.9px);
      /* Warna lapisan gelap */
    }

    .login-card,
    .form-control {
      background-color: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(4.9px);
      /* Transparansi pada card dan input text */
    }
  </style>
</head>

<body>
  <div class="login-overlay"></div> <!-- Lapisan blur -->
  <div class="container-fluid login-page">
    <div class="row justify-content-center align-items-center h-100 ">
      <div class="col-md-4 col-sm-12">
        <div class="card login-card my-5">
          <div class="card-body">
            <h1 class="text-center mb-5"><i class="fab fa-instagram"></i>Login</h1>
            <form method="POST">
              <?php if (isset($error_message)) : ?>
                <div class="alert alert-danger" role="alert">
                  <?php echo $error_message; ?>
                </div>
              <?php endif; ?>
              <div class="mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required />
              </div>
              <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
              </div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Log in</button>
              </div>
              <div class="mt-4 text-center">
                <a href="#" class="link-primary">Forgot password?</a>
              </div>
            </form>
            <div class="mt-4 text-center">
              <p>Don't have an account? <a href="register.php" class="link-primary">Register</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>