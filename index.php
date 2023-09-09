<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Table</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <style>
        .green-background {
            background: #00FF00 !important;
        }

        .red-background {
            background: #FF0000 !important;
        }
    </style>
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
            </div>
            <button id="btn0" class="btn btn-outline-secondary" style="width: fit-content; margin-right: 20px; margin-top: 20px">Add Data</button>
        </div>
    </form>

    <div class="container mt-5">
        <h2 class="mb-4">Filter Records</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="minAge">Min Age:</label>
                    <input type="number" class="form-control" name="minAge" id="minAge" placeholder="Min Age">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="maxAge">Max Age:</label>
                    <input type="number" class="form-control" name="maxAge" id="maxAge" placeholder="Max Age">
                </div>
            </div>
            <div class="col-md-3">
                <button id="filterButton" class="btn btn-primary">Apply Filter</button>
            </div>
            <div class="col-md-3">
                <button id="clearFilterButton" class="btn btn-secondary">Clear Filter</button>
            </div>
        </div>
    </div>

    <div id="div1" class="container mt-5">
        <h2 class="mb-4">Employee List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <!-- Data will be inserted here -->
            </tbody>
        </table>
        <button id="div2" class="btn btn-outline-secondary" style="width: 100px; margin-left: 5px; margin-top: 20px">Delete Table</button>
    </div>
    <!-- Add Bootstrap JS and jQuery scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        // if (parseInt(age) >= 18) {
        //     var verification = ['verified'];
        //     verification.id = ['verified'];
        // } else {
        //     var verification = ['unverified'];
        //     verification.id = ['verified']
        // }

        $('#addForm').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission
            var age = parseInt($("#age").val());
            var verification = age >= 18 ? 'verified' : 'unverified';

            // Send the form data to the server using AJAX
            $.ajax({
                url: 'function.php', // URL of your PHP script to submit data
                type: 'POST',
                data: {
                    name: $("#name").val(),
                    age: age,
                    verification: verification,

                    // verification: $('#verified').val(),
                    function: "save_content"
                },
                success: function(data) {
                    ShowContent();
                }
            });

            // Clear input fields
            $("#name").val("");
            $("#age").val("");
        });

        $("#filterButton").click(function() {
            // Get the min and max age values from the input fields
            var minAge = parseInt($("#minAge").val());
            var maxAge = parseInt($("#maxAge").val());

            // Call the function to filter records
            filterRecords(minAge, maxAge);
        });

        // Event handler for the clear filter button
        $("#clearFilterButton").click(function() {
            // Clear the min and max age input fields
            $("#minAge").val("");
            $("#maxAge").val("");

            // Show all records by calling ShowContent without filters
            ShowContent();
        });

        function updateRowBackgroundColor() {
            var rows = $("#table-body tr");
            rows.each(function() {
                var age = parseInt($(this).find("td:eq(1)").text());
                if (age >= 18) {
                    $(this).addClass('green-background');
                    $(this).removeClass('red-background');
                } else {
                    $(this).addClass('red-background');
                    $(this).removeClass('green-background');
                }
            });
        }


        function ShowContent() {
            $.ajax({
                url: 'function.php', // URL of your PHP script
                type: 'POST',
                data: {
                    function: "ShowContent"
                },
                success: function(data) {
                    var a = JSON.parse(data);
                    var tableBody = $("#table-body");
                    tableBody.empty();

                    DisplayData(a,tableBody);
                },
                error: function(error) {
                    console.error('Error:', error);
                },
            });
        }

        // Add Click Event Listener
        $(document).ready(function() {
            // Attach a click event listener to the button with id "div2"
            $("#div2").click(function(event) {
                // Call the delete function here or replace this with your actual delete logic
                deleteData();
            });
        });

        function deleteData() {
            $.ajax({
                url: 'function.php', // URL of your PHP script
                type: 'POST',
                data: {
                    function: "deletedata"
                },
                success: function(data) {
                    ShowContent();
                }
            });
        }

        function delete_data(id) {


            $.ajax({
                url: 'function.php', // URL of your PHP script
                type: 'POST',
                data: {
                    function: "delete_data",
                    id: id

                },

                success: function(data) {


                    ShowContent();

                }
            });
        }

        function update_content(id, updatedName, updatedAge, updatedverification) {

            $.ajax({
                url: 'function.php', // URL of your PHP script
                type: 'POST',
                data: {
                    name: $("input[name=name]").val(),
                    age: $("input[name=age]").val(),
                    verification: updatedverification,
                    function: "update_data",
                    id: id
                },

                success: function(data) {


                    ShowContent();

                }
            });
            var input1 = document.getElementById('name');
            input1.value = "";
            var input2 = document.getElementById('age');
            input2.value = "";

        }

        function filterRecords(minAge, maxAge) {
            $.ajax({
                url: 'function.php', // URL of your PHP script
                type: 'POST',
                data: {
                    function: "filterRecords",
                    minAge: minAge,
                    maxAge: maxAge
                },
                success: function(data) {
                    // Update the table with filtered records
                    var a = JSON.parse(data);
                    var tableBody = $("#table-body");
                    tableBody.empty();
                    DisplayData(a,tableBody);
                    
                },
                error: function(error) {
                    console.error('Error:', error);
                },
            });
        }

        function DisplayData(a,tableBody){
            for (let i = 0; i < a.length; i++) {
                        var name = a[i]['Name'];
                        var age = a[i]['Age'];
                        var id = a[i]['id'];
                        var tr = $("<tr>");
                        var td1 = $("<td>").text(name);
                        var td2 = $("<td>").text(age);
                        var btn = document.createElement("button");
                        btn.innerHTML = ("Delete");
                        btn.className = ("btn btn-outline-secondary");
                        btn.style = "width:100; height:40; margin-left:10px";
                        btn.id = (id);
                        btn.addEventListener("click", function() {
                            delete_data(id)
                        });
                        var edit_btn = $("<button>").text("Edit").addClass("btn btn-outline-secondary").css("width", "100px").attr("id", id);


                        edit_btn.on("click", function() {
                            // Your edit logic here
                            if (this.textContent === 'Edit') {

                                // Change the button text to "Save"
                                this.textContent = 'Save';
                                // Disable other edit buttons while editing
                                $('.edit_btn').prop('disabled', true);

                                // Get the current row's data
                                var currentRow = $(this).closest('tr');
                                var name = currentRow.find('td:eq(0)').text();
                                var age = currentRow.find('td:eq(1)').text();

                                // Populate the form fields with the row data
                                $('#name').val(name);
                                $('#age').val(age);
                                $('#verification').val(verification);
                            } else {
                                // Handle "Save" logic here
                                var updatedName = $('#name').val();
                                var updatedAge = $('#age').val();
                                var updatedverification = $('#verification').val();
                                var updatedverification = updatedAge >= 18 ? 'verified' : 'unverified';
                                update_content(this.id, updatedName, updatedAge, updatedverification);

                                // Restore the button text to "Edit"
                                this.textContent = 'Edit';
                                // Enable other edit buttons
                                $('.edit_btn').prop('disabled', false);
                            }


                        });

                        tr.append(td1);
                        tr.append(td2);
                        tr.append(btn);
                        tr.append(edit_btn);
                        tableBody.append(tr);  
                    }

                    updateRowBackgroundColor();
        }



        // function qualification_data() {
        //     $.ajax({
        //         url: 'function.php', // URL of your PHP script
        //         type: 'POST',
        //         data: {
        //             function: "qualification_data" // Send a specific function name to identify the request
        //         },
        //         success: function(data) {
        //             var qualificationData = JSON.parse(data);

        //             // Now, you have the 'id' and 'name' data in the 'qualificationData' variable.
        //             // You can use this data as needed in this function.
        //             console.log(qualificationData);

        //             // Example: Loop through the data and do something with it
        //             for (let i = 0; i < qualificationData.length; i++) {
        //                 var id = qualificationData[i]['id'];
        //                 var name = qualificationData[i]['name'];
        //                 console.log(name)

        //                 // Perform actions with 'id' and 'name'
        //                 // For example, you can create elements, append them to the DOM, etc.
        //             }
        //         },
        //         error: function(error) {
        //             console.error('Error:', error);
        //         },
        //     });
        // }


        $(document).ready(function() {
            // Fetch data from the server using jQuery AJAX
            ShowContent();
        });
    </script>

</body>

</html>