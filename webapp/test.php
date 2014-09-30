<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My page</title>
 
    <!-- CSS dependencies -->
    <link rel="stylesheet" type="text/css" href="style/css/bootstrap.min.css">
</head>
<body>
 
    <p>Content here. <a class="alert" href=#>Alert!</a></p>
 
    <!-- JS dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="style/js/bootstrap.min.js"></script>
 
    <!-- bootbox code -->
    <script src="style/js/bootbox.min.js"></script>
    <script>
        $(document).on("click", ".alert", function(e) {
            bootbox.alert("Hello world!", function() {
                console.log("Alert Callback");
            });
        });
    </script>
</body>
</html