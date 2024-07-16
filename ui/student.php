<?php
include '../connection.php';
// session_start();

if (isset($_SESSION['roll_no'], $_SESSION['sname'], $_SESSION['branch'])) {
    $rollNo = $_SESSION['roll_no'];
    $sname = $_SESSION['sname'];
    $branch = $_SESSION['branch'];

} else {
    header('location:../index.php');
    exit; // Make sure to exit after redirection
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Student Details</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="shortcut icon" href="../../images/favicon.png" />
    <style>
        .branch-heading {
            color: #000;
        }

        #loader {
            position: relative;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('../../images/loading3.gif') 50% 50% no-repeat rgb(249, 249, 249);
        }

        #loading {
            position: relative;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('../../images/loading1.gif') 50% 50% no-repeat rgb(249, 249, 249);
        }

        .table thead {
            background-color: #505050;
            color: white;
            font-weight: bold;
        }

        .table tbody {
            text-align: justify;
            text-justify: inter-word;
        }

        #lastrow {
            background-color: #92A0AD;
        }

        #co-att {
            display: none;
        }

        #wrong-order {
            display: none;
            color: red;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <?php include "header.php"; ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title" style="font-size: 18px;">Student Details</h4>
                                                <div class="row">
                                                    <div class="col-3 col-md-2">
                                                        <img src="images/face.jpg" alt="nature img" class="rounded"
                                                            height="100px" />
                                                    </div>
                                                    <div class="col-8">
                                                        <p style="font-size: 18px;"><b>Student Roll Number:</b>
                                                            <?php echo $rollNo; ?></p>
                                                        <p style="font-size: 18px;"><b>Student Name:</b> <?php echo $sname; ?></p>
                                                        <p style="font-size: 18px;"><b>Department:</b> <?php echo $branch; ?></p>
                                                        <br>
                                                        <br>
                                                    </div>
                                                    <div class="col-12 grid-margin stretch-card">

                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h4 class="card-title" style="font-size: 16px;">Courses</h4>
                                                                <div class="row">
                                                                    <?php
                                                                    $courses = ['Deep Learning', 'Information Security', 'Cloud Computing and Virtualization', '3D printing', 'Data Mining', 'Fundamentals of Data Analytics'];
                                                                    foreach ($courses as $course) {
                                                                        ?>
                                                                        <div class="col-md-4">
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <h5 class="course-heading">
                                                                                        <?php echo $course; ?>
                                                                                    </h5>

                                                                                    <br>
                                                                                    <button
                                                                                        class="predictGpaButton btn btn-primary"
                                                                                        data-course="<?php echo $course; ?>">Predict
                                                                                        SEE GPA
                                                                                    </button>
                                                                                    <p class="gpaOutput"></p>
                                                                                </div>
                                                                            </div>
                                                                            <br><br>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../vendors/base/vendor.bundle.base.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="../../js/jquery.cookie.js" type="text/javascript"></script>
    <script src="../../js/off-canvas.js"></script>
    <script src="../../js/hoverable-collapse.js"></script>
    <script src="../../js/template.js"></script>
    <script src="../../js/todolist.js"></script>
    <script>
        $(document).ready(function () {
            $(".predictGpaButton").click(function () {
                var course = $(this).data("course");
                var gpaOutput = $(this).siblings(".gpaOutput");

                $.ajax({
                    url: '../predict_gpa.php',
                    type: 'POST',
                    data: {
                        roll_no: '<?php echo $rollNo; ?>',
                        course: course // Pass the course information
                    },
                    success: function (response) {
                        // Update the corresponding <p> element with the predicted GPA
                        gpaOutput.text(response);
                    },
                    error: function () {
                        gpaOutput.text("Error in prediction.");
                    }
                });
            });
        });

    </script>
</body>

</html>