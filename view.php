<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>image testing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <h2>Uploaded Images</h2>
    <img style="width: 100px;height:100px" id="imageContainer">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        // Call updateImageList() when the document is ready
        $(document).ready(function() {
            updateImageList();
        });

        function updateImageList() {
            var imageContainer = $("#imageContainer")[0];
            console.log(imageContainer);


            // Fetch image data from the server
            $.ajax({
                url: 'function.php',
                type: 'POST',
                data: {
                    function: "getpic"
                },
                success: function(data) {

                    data = JSON.parse(data);
                    console.log(data);
                    $("#imageContainer").attr("src", data[0].path);

                }
            });
        }
    </script>
</body>

</html>