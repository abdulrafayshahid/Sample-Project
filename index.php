<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Table</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

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

                </div>
                <button class="btn btn-outline-secondary" style="width:100; margin-left: 13; margin-top: 50">Add Data</button>

            </div>
        </div>
    </form>


    <div id="div1" class="container mt-5">
        <h2 class="mb-4">Employee List</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                    </tr>
                </thead>
                <tbody id="table-body" class="table-body">
                    <!-- Data will be inserted here -->
                </tbody>
            </table>
    </div>

    <button id="div2" class="btn btn-outline-secondary" style="width:100; margin-left: 55; margin-top: 30">Delete</button>

    <!-- Add Bootstrap JS and jQuery scripts -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

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


        function ShowContent() {
            $.ajax({
                url: 'function.php', // URL of your PHP script
                type: 'POST',
                data: {
                    function: "ShowContent"
                },
                success: function(data) {

                    a = JSON.parse(data)
                    var tableBody = document.getElementById("table-body");
                    tableBody.innerHTML = "";
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

        //Add Click Event Listener
        $(document).ready(function () {
            // Attach a click event listener to the button with id "div2"
            $("#div2").click(function (event) {
                // Call the delete function here or replace this with your actual delete logic
                deletedata();
                
                
            });
        
        });


        function deletedata() {
            console.log('error');
            $.ajax({
                url: 'function.php', // URL of your PHP script
                type: 'POST',
                data: {
                    function: "deletedata"
                },

                success: function(data) {
                    console.log(data);
                    
                    ShowContent();

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