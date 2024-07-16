<?php
include 'connection.php';

if (isset($_POST['roll_no'])) {
    $rollNo = $_POST['roll_no'];
    $course = $_POST['course'];

    // Fetch the marks from the database for the given roll number and course
    $query = "SELECT `CAT-1`, `CAT-2`, `PCAT-1`, `PCAT-2`, `Attendance`, `CGPA`, `Active_Backlogs`, `Physical_Health` FROM marks WHERE roll_no = ? AND Course = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ss", $rollNo, $course);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Prepare data for prediction
        $data = [
            'CAT-1' => $row['CAT-1'],
            'CAT-2' => $row['CAT-2'],
            'PCAT-1' => $row['PCAT-1'],
            'PCAT-2' => $row['PCAT-2'],
            'Attendance' => $row['Attendance'],
            'CGPA' => $row['CGPA'],
            'Active_Backlogs' => $row['Active_Backlogs'],
            'Physical_Health' => $row['Physical_Health']
        ];

        // Call the Python script to get the prediction
        $command = escapeshellcmd('python predict_gpa.py');
        $process = proc_open($command, [0 => ["pipe", "r"], 1 => ["pipe", "w"], 2 => ["pipe", "w"]], $pipes);

        if (is_resource($process)) {
            fwrite($pipes[0], json_encode($data));
            fclose($pipes[0]);
            
            // Read the predicted GPA from the output of the Python script
            $predicted_gpa = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            
            // Check for any errors
            $errors = stream_get_contents($pipes[2]);
            fclose($pipes[2]);
            
            // Close the process
            $return_value = proc_close($process);
            
            if ($return_value === 0) {
                echo "Predicted SEE GPA for $course is : " . $predicted_gpa;
            } else {
                echo "Error in executing the Python script.";
            }
        } else {
            echo "Failed to execute the Python script.";
        }
    } else {
        echo "No data found for the selected course.";
    }
}
?>
