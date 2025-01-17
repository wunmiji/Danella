<head>
    <title>Using Flatpickr</title>
    <!--  Flatpicker Styles  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/themes/dark.css">

    <style>
        body {
            text-align: center;
            background: cornflowerblue;
        }

        img {
            width: 50px;
            border-radius: 50px;
        }

        input {
            border: 2px solid whitesmoke;
            border-radius: 20px;
            padding: 12px 10px;
            text-align: center;
            width: 250px;
        }

        button {
            border: none;
            border-radius: 10px;
            padding: 12px 10px;
            text-align: center;
            cursor: pointer;
            background: coral;
            color: whitesmoke;
        }
    </style>
</head>

<body>
    <img src="https://chmln.github.io/flatpickr/images/logo.png" alt="flatpickr">
    <h1>Flatpickr</h1>
    <hr>
    <div>
        <h2>Basic DateTime</h2>
        <input type="text" id="basicDate" placeholder="Please select Date Time" data-input>

        <h2>Range Datetime</h2>
        <input type="text" id="rangeDate" placeholder="Please select Date Range" data-input>

        <h2>Time Picker</h2>
        <input type="text" id="timePicker" placeholder="Please select Time">
    </div>
    <h2>Week Number with Reset Date</h2>
    <div class=resetDate>
        <input type="text" placeholder="Select Date.." data-input>
        <button class="input-button" title="clear" data-clear>RESET</button>
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!--  Flatpickr  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.js"></script>

    <script>
        $("#basicDate").flatpickr({
            enableTime: true,
            dateFormat: "F, d Y H:i"
        });

        $("#rangeDate").flatpickr({
            mode: 'range',
            dateFormat: "Y-m-d"
        });

        $("#timePicker").flatpickr({
            enableTime: true,
            noCalendar: true,
            time_24hr: true,
            dateFormat: "H:i",
        });

        $(".resetDate").flatpickr({
            wrap: true,
            weekNumbers: true,
        });
    </script>
</body>