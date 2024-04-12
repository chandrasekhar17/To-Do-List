<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch Data with Ajax</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

    <div id="data-container">
        <!-- Data will be displayed here -->
    </div>

    <script>
        $(document).ready(function () {
            // Make an Ajax request to fetch data from the fake API
            $.ajax({
                url: 'https://jsonplaceholder.typicode.com/users', // Fake API endpoint
                method: 'GET',
                dataType: 'json', // Expect JSON response
                success: function (data) {
                    // Handle the successful response
                    displayData(data);
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error('Error fetching data:', error);
                }
            });

            // Function to display data
            function displayData(data) {
                // Clear previous data
                $('#data-container').empty();

                // Iterate over each item in the data array and display it
                data.forEach(function (item) {
                    $('#data-container').append('<div><h3>' + item.id + '</h3><p>' + item.name + '</p></div>');
                });
            }
        });
    </script>

</body>

</html>