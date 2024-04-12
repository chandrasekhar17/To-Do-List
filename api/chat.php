<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update To-Do Item</title>
    <link href="styles.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h2>Provide your Details, Our team will get back to you</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="update-form">
            <input id="title" type="hidden" name="id" value="<?php echo $id; ?>">
            <div>
                <label>Title:</label>
                <input class="post-title" type="text" name="title" value="<?php echo isset($title) ? $title : ''; ?>">
            </div>
            <div>
                <label>Description:</label>
                <textarea id="desc" class="post-description"
                    name="description"><?php echo isset($description) ? $description : ''; ?></textarea>
            </div>
            <div><label for="email">Email</label><br>
                <input name="email" id="email" type="text" placeholder="enter your email" class="email" />
            </div>
            <div><label for="name">Name</label><br><input name="name" class="email" type="text"></div>
            <div>
                <input id="name" type="submit" value="Submit" class="btn btn-success" />
                <a href="../login/index.php" class="btn btn-danger"><strong>Back</strong></a>
            </div>
        </form>
    </div>
</body>

</html>
<script>
    function check() {
        var name = document.getElementById('name').value;
        var email = document.getElementById('email').value;
        var title = document.getElementById('title').value;
        var desc = document.getElementById('desc').value;
        $.ajax({
            type: 'POST',
            url: 'pro.php',
            data: {
                name: name,
                email: email,
                title: title,
                des: desc
            },
            success: function (res) {
                $('#result').html(res);
                if (res == 'go') {
                    alert(res);
                }
            };
        });
    }
</script>