<?php
    include("../connection/conn.php");

    define('ENCRYPTION_KEY', getenv('MY_SECRET_KEY'));


    function decryptData($encryptedData)
    {
        $key = ENCRYPTION_KEY;
        $data = base64_decode($encryptedData);
        $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($data, 0, $ivLength); // Extract the IV
        $encrypted = substr($data, $ivLength); // Extract the encrypted data
        return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
    }


    function encryptData($data)
    {
        $key = ENCRYPTION_KEY;
        $iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc')); // Generate a random IV
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($iv . $encrypted); // Store IV and encrypted data together
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Alumni Tracer - Super Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../template/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib../template/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../template/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../template/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(function() {
                    document.getElementById("spinner").classList.remove("show");
                }, 1000);
            });

        </script>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"></i>Alumni Tracer</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="pictures/default.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">Super Admin</h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                  
                <a href="superAdmin.php" class="nav-item nav-link ">
                    <i class="fa fa-check-circle me-2"></i>Approve Schools
                </a>
                <a href="pendingSchool.php" class="nav-item nav-link">
                    <i class="fa fa-clock me-2"></i>Pending Schools
                </a>
                <a href="approveAdmins.php" class="nav-item nav-link active">
                    <i class="fa fa-user-check me-2"></i>Approve Admins
                </a>
                <a href="pendingAdmins.php" class="nav-item nav-link">
                    <i class="fa fa-user-clock me-2"></i>Pending Admins
                </a>

                   
                   
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
              
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                <input id="searchInput" class="form-control border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                   
                   
                    <div class="nav-item dropdown">
                            <a href="../index.php" class = "btn btn-danger" style = "margin: 10px;">Logout</a>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Approved Admins</h6>
                            <div class="table-responsive">
                           <table class="table">
                                    <thead>
                                        <tr>
                                        <th scope="col">No.</th>
                                            <th scope="col">Profile Picture</th>
                                            <th scope="col">Fullname</th>
                                            <th scope="col">School Role</th>
                                            <th scope="col">School</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="schoolTableBody">
                                            <?php
                                                 $sqlGetSchool = "SELECT * FROM r_accounts WHERE status = 'Approved'";
                                                $queryGetSchool = mysqli_query($conn, $sqlGetSchool);

                                                $number = 0;

                                                while ($getData = mysqli_fetch_assoc($queryGetSchool)) {
                                                    $number++;
                                                    $uniqueModalId = "modal" . $getData['id']; // Create a unique modal ID
                                            ?>
                                            <tr class="school-row">
                                            <th scope="row"><h6 style="color: grey; margin-top: 7px;"><?php echo $number; ?></h6></th>
                                            <td><img src="<?php echo $getData['profile_img']; ?>" alt="admin picture" style="width: 30px; height: 30px;"></td>
                                            <td class="school-name"><h6 style="color: grey; margin-top: 7px;"><?php echo decryptData($getData['name']); ?></h6></td>
                                            <td class="school-name"><h6 style="color: grey; margin-top: 7px;"><?php echo decryptData($getData['school_role']); ?></h6></td>
                                            <td class="school-name"><h6 style="color: grey; margin-top: 7px;"><?php echo decryptData($getData['school']); ?></h6></td>
                                                <td>
                                                    <div>                
                                                        <!-- Button to open the modal -->
                                                        <button type="button" class="btn" style="background-color: red; color: white; margin-left: 13px;" data-bs-toggle="modal" data-bs-target="#<?php echo $uniqueModalId; ?>">
                                                            <i class="fa fa-times"></i>
                                                        </button>

                                                        <!-- Modal Structure -->
                                                        <div class="modal fade" id="<?php echo $uniqueModalId; ?>" tabindex="-1" aria-labelledby="myModalLabel<?php echo $getData['id']; ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="myModalLabel<?php echo $getData['id']; ?>">Delete Modal</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to delete this entry?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                                        <a type="button" class="btn btn-success" href="action/deleteAdmin.php?id=<?php echo $getData['id']; ?>">Confirm Delete</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            ?>
                                            <!-- Placeholder row for "No results found" -->
                                            <tr id="noResultsRow" style="display: none;">
                                                <td colspan="6" class="text-center" style="background-color: red; color: white; font-weight: bolder;">No results found</td>
                                            </tr>
                                        </tbody>

                                </table>

                                <script>
                                  
                                    const searchInput = document.getElementById('searchInput');
                                    const schoolRows = document.querySelectorAll('.school-row');
                                    const noResultsRow = document.getElementById('noResultsRow');

                                   
                                    searchInput.addEventListener('input', function() {
                                        const searchText = searchInput.value.toLowerCase();
                                        let matchFound = false;

                                        schoolRows.forEach(row => {
                                           
                                            const schoolName = row.querySelector('.school-name').textContent.toLowerCase();

                                            // Show or hide row based on match
                                            if (schoolName.includes(searchText)) {
                                                row.style.display = '';
                                                matchFound = true;
                                            } else {
                                                row.style.display = 'none';
                                            }
                                        });

                                        // Show or hide the no-results row based on match status
                                        noResultsRow.style.display = matchFound ? 'none' : '';
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table End -->


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="../index.php">Alumni Tracer</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Developed By <a href="#">5 - SLSU Students</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../template/lib/chart/chart.min.js"></script>
    <script src="../template/lib/easing/easing.min.js"></script>
    <script src="../template/lib/waypoints/waypoints.min.js"></script>
    <script src="../template/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../template/lib/tempusdominus/js/moment.min.js"></script>
    <script src="../template/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../template/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="../template/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>