<?php
// Start the session
session_start();
$_SESSION['valid_user'] = true;
// Check if session has expired

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=0.8">

        <link rel="icon" href="icons/prescription-bottle-solid.png" type="image/png">
        <link rel="shortcut icon" href="icons/prescription-bottle-solid.png" type="image/png">
        <title>UNEP Staff Portal</title>
        <link rel="stylesheet" href="css/cssstyle.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
       
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
            /* Sidebar Styles */
            .sidebar {
                width: 250px;
                top: 60px;
                /* background-color: #0077be; */
                color: 000;
                padding: 15px;
                height: 100vh;
                position: fixed;
                top: 0;
                left: -250px;
                transition: all 0.3s ease-in-out;
            }

            .sidebar.open {
                left: 0;
                top: 60px;
            }
            .navbar-toggler {
                background-color: #fff !important;
            }
            .sidebar a {
                color: #000;
                display: block;
                padding: 10px;
                text-decoration: none;
            }

          
            .sidebar a:hover {
                background-color: #0077be;
                opacity:0.8;
                 color: #000;
            }

            /* Responsive adjustments */
            @media (min-width: 768px) {
                .sidebar {
                    top: 60px;
                    left: 0;
                }
            }

            /* Content Styles */
            .content {
                margin-left: 250px;
                padding: 20px;
                transition: margin-left 0.3s ease-in-out;
            }

            @media (max-width: 768px) {
                .content {
                    margin-left: 0;
                }
            }

            /* Overlay for mobile view */
            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 50%;
                height: 100%;
                background-color: #0077be;
                z-index: 998;
                display: none;
            }

            .overlay.show {
                display: block;
            }
/* Hide the div by default */
.logged-info {
    display: none !important;
}

/* Show the div only when screen width is 768px or larger */
@media (min-width: 768px) {
    .logged-info {
        display: flex !important;
    }
}

/* Hide the div by default */
.logged-info2 {
    display: none !important;
}

/* Show the div only when screen width is 768px or larger */
@media (max-width: 768px) {
    .logged-info2 {
        display: flex !important;
    }
}
.form-label {color: #0077be !important;}
        </style>
     
    </head>
    <body>


           <nav class="navbar navbar-expand-lg ">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="#"><i class="fas fa-tachometer-alt"></i> Staff  Portal </a>
        <button class="navbar-toggler" type="button" onclick="toggleSidebar()">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="d-flex align-items-center logged-info">
            <!-- User info and logout link -->
            <a class="nav-link  me-3" href="#">
                
                Logged in as: <?php echo htmlspecialchars($_SESSION["user_name"]); ?>
            </a>
            <a class="nav-link text-white" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</nav>

        <!-- Main Layout -->
        <div class="d-flex flex-grow-1">
            <div class="sidebar" id="sidebar">
             <div class="logged-info2">
            <!-- User info and logout link -->
            </div>
                <a href="main.php"><i class="fas fa-user-md"></i> Staff</a>
               
               

           <div class="logged-info2">  <a class="nav-link text-white" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
                <!-- Footer -->
            </div>
            <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
            <div class="content">

<?php
include('config/conn.php'); // Include database configuration file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    // Validate inputs

$IndexNumber = trim($_POST['IndexNumber']);
$FullNames = trim($_POST['Full_Names']);
$Email = trim($_POST['Email']);
$CurrentLocation = trim($_POST['CurrentLocation']);
$HighestLevelOfEducation = trim($_POST['HighestLevelOfEducation']);
$DutyStation = trim($_POST['DutyStation']);
$AvailabilityForRemoteWork = trim($_POST['AvailabilityForRemoteWork']);
$Software_Expertise = trim($_POST['Software_Expertise']);
$Software_Expertise_Level = trim($_POST['Software_Expertise_Level']);
$Language = trim($_POST['Language']);
$Level_of_Responsibility = trim($_POST['Level_of_Responsibility']);



// Validation flags
$errors = [];


if (empty($errors)) {
    // Prepare SQL statement to prevent SQL injection

    $sql = "INSERT INTO tbl_staff (Index_Number, Full_Names, Email, Current_Location, Highest_Level_Of_Education, Duty_Station, Availability_For_Remote_Work, Software_Expertise, Software_Expertise_Level, Language, Level_of_Responsibility) VALUES (?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssssssss", $IndexNumber, $FullNames, $Email, $CurrentLocation, $HighestLevelOfEducation, $DutyStation,$AvailabilityForRemoteWork,$Software_Expertise,$Software_Expertise_Level,$Language,$Level_of_Responsibility);
        // Attempt to execute the statement
        if (mysqli_stmt_execute($stmt)) {
          
            $_SESSION['success'] = "New Staff successfully created!";
            // echo "<script>window.location.href = 'main.php';</script>";
            // exit;
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again later.";
            // echo "<script>window.location.href = 'main.php';</script>";
            // exit;
        }
        mysqli_stmt_close($stmt);
    }
} else {
    $_SESSION['error'] = implode("<br>", $errors);
    // echo "<script>window.location.href = 'main.php';</script>";
    // exit;
}


}
?>
<div class="container"> 

<button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#createForm" aria-expanded="false" aria-controls="createForm">
        Add New Staff
    </button>
    <div id="createForm">

 <h5>Create New  Staff</h5>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
<?php endif; ?><div class="form-container">
  
   <form action="main.php" method="POST">
        <div class="row ">
            <!-- Column 1 -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="IndexNumber" class="form-label">Index Number</label>
                    <input type="text" placeholder="Enter IndexNumber" class="form-control" id="IndexNumber" name="IndexNumber" required>
                </div>
                <div class="mb-3">
                    <label for="FullNames" class="form-label">Full Names </label>
                    <input type="text" class="form-control" placeholder="Enter Full_Names" id="Full_Names" name="Full_Names" >
                </div>
            <div class="mb-3">
                    <label for="Duty_Station " class="form-label">Duty Station </label>
                  
                     <Select  class="form-control" id="Duty_Station" name="DutyStation" ><option>Select Duty Station</option>  <option value="Station 1">Station 1</option>
                        <option value="Station 2">Station 2</option> </Select>

                </div>
                <div class="mb-3">
                    <label for="Language " class="form-label">Language </label>
                    <input type="text" class="form-control" placeholder="Enter Language" id="Language" name="Language" >
                </div>
            </div>

            <!-- Column 2 -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="location" class="form-label">Email </label>
                    <input type="emsil" class="form-control" id="Email" placeholder="Enter Email" name="Email" required>
                </div>
                <div class="mb-3">
                    <label for="CurrentLocation" class="form-label">Current Location </label>
                    <input type="text" class="form-control" placeholder="Enter Current Location" id="CurrentLocation" name="CurrentLocation" >
                </div>
 <div class="mb-3">
                    <label for="Availability_For_Remote_Work" class="form-label">Availability for Remote Work </label>
                    <input type="number" min="0.1" class="form-control" placeholder="Enter Availability For Remote Work" id="Availability_For_Remote_Work" name="AvailabilityForRemoteWork" >
                </div>
 <div class="mb-3">
                    <label for="email" class="form-label">Level of Responsibility</label>
                    <Select  class="form-control" id="Level_of_Responsibility" name="Level_of_Responsibility" ><option>Select Level of Responsibility</option>
                    <option value="Responsibility 1">Responsibility 1</option>
                        <option value="Responsibility 2">Responsibility 2</option> </Select>
                </div>
            </div>
            <div class="col-md-4">

                <div class="mb-3">
                    <label for="incharge" class="form-label">Highest Level Of Education </label>
                    
                    <Select  class="form-control" placeholder="Enter Highest Level Of Education" id="HighestLevelOfEducation" name="HighestLevelOfEducation" ><option>Select Highest Level Of Education</option>
                        <option value="Level 1">Level 1</option>
                        <option value="Level 2">Level 2</option>
                     </Select>
                </div>
                 <div class="mb-3">
                    <label for="incharge" class="form-label">Software Expertise </label>
                   
                     <Select  class="form-control" id="Software_Expertise" name="Software_Expertise" ><option>Select Software Expertise</option>
                      <option value="Expertise 1">Expertise 1</option>
                        <option value="Expertise 2">Expertise 2</option> </Select>
                </div>
                 <div class="mb-3">
                    <label for="incharge" class="form-label">Sofware Expertise Level </label>
                    <Select  class="form-control" id="Software_Expertise_Level" name="Software_Expertise_Level" ><option>Select Software Expertise Level</option>
                    <option value="Expertise Level 1">Expertise Level 1</option>
                        <option value="Expertise Level 2">Expertise Level 2</option> </Select> </Select>
                </div>
            </div>

        </div>
        <button type="submit" class="btn btn-primary">Create New  Staff</button>
    </form>
    </div>
    </div>
   <?php
    $limit = 10; // Number of records per page
    $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1; // Ensure $page is at least 1
    $start = ($page - 1) * $limit;
   $sql = "SELECT * FROM tbl_staff  LIMIT ?, ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "ii",  $start, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Query failed: " . mysqli_error($link));
    }

// Fetch total records
    $sql_count = "SELECT COUNT(Index_Number) AS total FROM tbl_staff";
    $stmt_count = mysqli_prepare($link, $sql_count);
    
    mysqli_stmt_execute($stmt_count);
    $result_count = mysqli_stmt_get_result($stmt_count);
    $total_records = mysqli_fetch_assoc($result_count)['total'];
    $total_pages = ceil($total_records / $limit);

// Close statements
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmt_count);
    ?>
    <br><h5>Staff List</h5>
    <div class="form-container">
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Index_Number</th>
                <th>Full_Names</th>
                <th>Email</th>
                <th>Current_Location</th>
                <th>Highest_Level_Of_Education</th>
                 <th>Duty_Station</th>
                 <th>Availability_For_Remote_Work</th>
                <th>Software_Expertise</th>
                <th>Software_Expertise_Level</th>
                <th>Language</th>
                <th>In Level_of_Responsibility</th>
                 <th>Action</th>
                  
            </tr>
        </thead>
        <tbody>
<?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Index_Number']); ?></td>
                    <td><?php echo htmlspecialchars($row['Full_Names']); ?></td>
                    <td><?php echo htmlspecialchars($row['Email']); ?></td>
                    <td><?php echo htmlspecialchars($row['Current_Location']); ?></td>
                    <td><?php echo htmlspecialchars($row['Highest_Level_Of_Education']); ?></td>
                      <td><?php echo htmlspecialchars($row['Duty_Station']); ?></td>
                    <td><?php echo htmlspecialchars($row['Availability_For_Remote_Work']); ?></td>
                    <td><?php echo htmlspecialchars($row['Software_Expertise']); ?></td>
                    <td><?php echo htmlspecialchars($row['Software_Expertise_Level']); ?></td>
                    <td><?php echo htmlspecialchars($row['Language']); ?></td>
                      <td><?php echo htmlspecialchars($row['Level_of_Responsibility']); ?></td>
                    <td>
                <!-- Edit link -->
                <a href="main.php?view=edit_staff&id=<?php echo $row['Index_Number']; ?>" class="btn btn-primary btn-sm">Edit</a>
                <!-- Delete link -->
                <a href="delete_staff.php?id=<?php echo $row['Index_Number']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this staff?');">Delete</a>
            </td>
                </tr>
<?php endwhile; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination">
<?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="view_staff.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
<?php endfor; ?>
        </ul>
    </nav>
    </div>
</div>


  </div>

        </div>

       
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
