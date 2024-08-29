<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>

    <div class="container" style="margin-top: 5%; text-align: center;">
        <div class="row">
            <div class="col-md-8">
                <form action="#">
                    <input type="number" id="fiveDigitInput" name="fiveDigitInput" onkeyup="check_digit()">

                </form>
                <button onclick="test()" id="start_btn">Start</button>
                <p id="demo2"></p>
                <p id="demo"></p>


            </div>
            <div class="col-md-4" id="" style="border:1px solid black">
                <b><p style="text-decoration:underline">Comparison Result</p></b>
                <div class="result_area"></div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        var count = 1;
        var str = "";
        var intervalId;
        function test() {
            let input = document.getElementById("fiveDigitInput").value;

            if (input.length < 5) {
                alert("Please Enter 5 Digits.")
            } else {
                document.getElementById("fiveDigitInput").disabled = true;
                document.getElementById("start_btn").disabled = true;
                intervalId = setInterval(function () {

                    if (count <= 5) {
                        str += document.getElementById("demo2").innerText.toString();
                        count++;
                        document.getElementById("demo").innerHTML = str;
                        if (count > 5) {

                            stopInter();
                        }
                    }
                }, 5000);//60000
            }
        }

        function stopInter() {
            clearInterval(intervalId);
            // ajax post
            let input = document.getElementById("fiveDigitInput").value;
            
            $.ajax({
                type: 'get',
                url: 'http://localhost:8080/random_num_col/number_compare.php',
                data: { input: input, str: str },
                beforeSend: function () {
                    console.log("loading");
                },
                success: function (data) {
                    // reset count and value
                    count = 1;
                    str = "";
                    document.getElementById("fiveDigitInput").disabled = false;
                    document.getElementById("start_btn").disabled = false;
                    var content = $(data);
                    $(".result_area").html(content);
                    console.log("success");
                    // $(".display-content").fadeIn(10);
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    console.log(msg);
                },

            });
        }


        setInterval(function () {
            document.getElementById("demo2").innerHTML =
                Math.floor(Math.random() * 10);
        }, 100);


        function check_digit() {
            let input = document.getElementById("fiveDigitInput").value;
            if (input.length > 5) {
                document.getElementById("fiveDigitInput").value = input.slice(0, 5);
            }
        }
    </script>
</body>

</html>