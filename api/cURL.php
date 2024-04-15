<?php
// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/users');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);

// Execute cURL request
$response = curl_exec($ch);

// Check for errors
if ($response === false) {
    // Handle cURL error
    $error = curl_error($ch);
    echo 'Error fetching data: ' . $error;
} else {
    // Decode JSON response
    $data = json_decode($response, true);

    // Display data
    echo '<div id="data-container">';
    foreach ($data as $item) {
        echo '<div><h3>' . $item['id'] . '</h3><p>' . $item['name'] . '</p></div>';
    }
    echo '</div>';
}

// Close cURL session
curl_close($ch);
