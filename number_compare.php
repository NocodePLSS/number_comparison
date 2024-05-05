<?php
// Database credentials
$servername = "localhost"; // server name
$username = "root"; //  MySQL username
$password = ""; // yMySQL password
$database = "interview_task"; // MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

}

if (isset($_GET['input']) && isset($_GET['str'])) {

    echo "<p>User Input: " . $_GET['input'] . "</p>
    <p>Random Output: " . $_GET['str'] . "</p>";
    // check similar digits

    $get_same_digit = check_similar_digits($_GET['input'], $_GET['str']);
    echo "<p>" . $get_same_digit . "</p>";

    // check continuos digits
    echo "<p>" . check_continuos_digits($_GET['input'], $_GET['str']) . "</p>";

    if (check_permutation($_GET['input'], $_GET['str'])) {
        echo "<p>They are permutations of each other.</p>";
    } else {
        echo "<p>They are not permutations of each other.</p>";
    }

    mysqli_query($conn, "INSERT INTO nano_transactions(user_input, random_output)
    VALUES('" . $_GET['input'] . "', '" . $_GET['str'] . "')");
}


function check_similar_digits($user_input, $random_output)
{
    $user_arr = str_split($user_input);
    $random_output = str_split($random_output);
    $similar_store = array();
    foreach ($user_arr as $key => $value) {
        if ($value == $random_output[$key]) {
            array_push($similar_store, $value);
        }
    }
    if (count($similar_store) <= 0) {
        return "No similar digits.";
    } else {
        $string = implode(",", $similar_store);
        return "Similar digits: " . $string;
    }

}

function check_continuos_digits($user_input, $random_output)
{
    $max_length = 0;
    $max_arr_store = array();
    $temp_length = 0;
    $temp_arr_store = array();
    $user_arr = str_split($user_input);
    $random_output = str_split($random_output);
    $left = 0;
    $right = 0;

    while ($right < count($random_output)) {
        if ($user_arr[$right] == $random_output[$right]) {
            array_push($temp_arr_store, $user_input[$right]);
            $temp_length++;

            if ($temp_length > $max_length) {
                $max_length = $temp_length;
                $max_arr_store = $temp_arr_store;
            }
            $right++;
        } else {
            $temp_arr_store = array();
            $temp_length = 0;
            $left = $right + 1; // Move left pointer to the next position
            $right = $left; // Reset right pointer
        }
    }

    if ($max_length <= 1) {
        return "No continuos digits found.";
    } else {
        $string = implode(",", $max_arr_store);

        return "Continuous digits: " . $string;
    }
}

function check_permutation($user_input, $random_output)
{
    $user_arr = str_split($user_input);
    $random_output = str_split($random_output);
    sort($user_arr);
    sort($random_output);

    return $user_arr == $random_output;
}




