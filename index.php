<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Table</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <form id="addForm">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="age">Age:</label>
                        <input type="number" class="form-control" name="age" id="age" placeholder="Enter Age">

                    </div>
                    <button class="btn btn-outline-secondary" style="width:100; margin-left: 125; margin-top: 50;">Add Data</button>

                </div>
            </div>
        </div>
    </form>


    <div class="container mt-5">
        <h2 class="mb-4">Employee List</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <!-- Data will be inserted here -->
                </tbody>
            </table>
    </div>

    <!-- Add Bootstrap JS and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRkFFB5cI7x4fo5Vp2NqG6qzP3Xn5lC5u5t6L3tzu" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>


    <script>
        $('#addForm').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Send the form data to the server using AJAX
            $.ajax({
                url: 'function.php', // URL of your PHP script to submit data
                type: 'POST',
                data: {
                    name: $("input[name=name]").val(),
                    age: $("input[name=age]").val(),
                    function: "save_content"

                },
                success: function(data) {
                    console.log(data);
                    ShowContent();
                }

            });
        });

        function ShowContent(){
            $.ajax({
                url: 'function.php', // URL of your PHP script
                type: 'POST',
                data: {
                    function: "ShowContent"
                },
                success: function(data) {

                    a = JSON.parse(data)
                    var tableBody = document.getElementById("table-body");
                    tableBody.innerHTML="";
                    console.log(tableBody);
                    for (let i = 0; i < a.length; i++) {
                        var name = a[i]['Name'];
                        var age = a[i]['Age'];
                        var tr = document.createElement("tr");
                        var td1 = document.createElement("td");
                        var td2 = document.createElement("td");
                        td1.innerHTML = name;
                        td2.innerHTML = (age);
                        tr.appendChild(td1);
                        tr.appendChild(td2);
                        tableBody.appendChild(tr);

                    };
                },
                error: function(error) {
                    console.error('Error23:', error);
                }
            });
        }


        $(document).ready(function() {
            // Fetch data from the server using jQuery AJAX
            ShowContent();
        });
    </script>
</body>

</html>