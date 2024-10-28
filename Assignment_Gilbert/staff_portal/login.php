<!-- This page will have a login form 
username and password with submit button and forgot password link
For the interest of time, I will reuse what I already developed in my previous projects
 -->

<?php
session_start();
include('config/conn.php'); // Include database configuration file

// Initialize variables

$email_err = $password_err = $login_err = "";

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT id, user_name,password FROM tbl_staff_user 	 WHERE user_name = ?";
        
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $user_name,$password);
                    if (mysqli_stmt_fetch($stmt)) {
                      
                                session_start();
                                 $_SESSION["id"] = $id;
                                      // Standard user
                                                header("Location: main.php");
                                                 $_SESSION["logged_in"] = true;
                                                   $_SESSION["user_name"] = $user_name;
                                                 
                    }
                } else {
                    $login_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="icons/prescription-bottle-solid.png" type="image/png">
    <link rel="shortcut icon" href="icons/prescription-bottle-solid.png" type="image/png">
   
    <link rel="stylesheet" href="css/cssstyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .main-content {
            display: flex;
            flex-grow: 1;
            height: 100%;
        }

        /* Banner: Adjust width on different screen sizes */
        .banner {
            background: url('uploads/banner.jpg') no-repeat center center;
            background-size: cover;
        }

        /* Login Form container */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }

        .login-box {
            width: 90%;
           
            height: 60%;
            padding: 20px;
            /* background-color: #ffffff; */
            border-radius: 8px;
            /* box-shadow: 0 0 10px #0077be; */
            text-align: left;
        }

        .login-title {
            margin-bottom: 20px;
        }

        .login-btn {
            width: 100%;
        }

        footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
        }

        @media (min-width: 768px) {
            .banner {
                width: 50%;
                height: 100%;
            }

            .login-container {
                width: 50%;
            }
        }

        @media (max-width: 767.98px) {
            .main-content {
                flex-direction: column;
            }

            .banner {
                width: 100%;
                height: 200px;
            }

            .login-container {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="main-content">
        <!-- Banner Image -->
        <div class="banner"></div>

        <!-- Login Form -->
        <div class="login-container">
            <div class="login-box">
            
             <h1  style="color:#0077be;">Staff Portal</h1>
                <h5 class="login-title" style="color:#0077be;">Login to continue</h5>

                <?php if (!empty($login_err)) {
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                } ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="mb-3">
                        <label for="email" style="color:#0077be; opacity:0.6;" class="form-label">Email Address</label>
                        <input type="email" class="form-control " id="email" name="email" placeholder="Enter your email" required>
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div>
                    <div class="mb-3">
                        <label for="password" style="color:#0077be; opacity:0.6;" class="form-label">Password</label>
                        <input type="password" class="form-control " id="password" name="password" placeholder="Enter your password" required>
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <button type="submit" style="background-color:#0077be !important;" class="btn btn-primary login-btn">Login</button>
                </form>

                <div class="text-left mt-3">
                    <a href="forgot_password.php" class="text-muted">Forgot your password?</a>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
