<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hridayasparsham</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #121212;
            color: #ffffff;
            position: relative;
            overflow: auto;
            height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(30, 30, 30, 0.8);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .dropdown, .search-box {
            margin: 10px 0;
        }
        .dropdown select, .search-box input[type="submit"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        .search-box input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .search-box input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            display: none;
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        .centered-title {
            text-align: center;
        }
        .custom-font {
            font-family: unifrakturcook;
            font-size: 3em;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="centered-title custom-font">Hridayasparsham</h1>

    <div class="dropdown">
        <form action="main.php" method="POST">
            <select id="options" name="options" required>
                <option value="" disabled selected>Select a Blood Group</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
            <div class="search-box">
                <input type="submit" value="Search">
            </div>
        </form>
    </div>

    <!-- Table to display Excel data -->
    <table id="excelTable">
        <thead>
            <tr></tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script>
    const excelFiles = {
        "A+": "APositive.xlsx",
        "A-": "path/to/A_minus.xlsx",
        "B+": "path/to/B_plus.xlsx",
        "B-": "path/to/B_minus.xlsx",
        "AB+": "path/to/AB_plus.xlsx",
        "AB-": "path/to/AB_minus.xlsx",
        "O+": "path/to/O_plus.xlsx",
        "O-": "path/to/O_minus.xlsx"
    };

    function loadExcel(selectedValue) {
        if (selectedValue && excelFiles[selectedValue]) {
            fetch(excelFiles[selectedValue])
                .then(response => response.arrayBuffer())
                .then(data => {
                    const workbook = XLSX.read(data, { type: 'array' });
                    const sheetName = workbook.SheetNames[0];
                    const sheet = workbook.Sheets[sheetName];
                    const excelData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

                    displayTable(excelData);
                })
                .catch(err => console.error('Error loading Excel file:', err));
        }
    }

    function displayTable(data) {
        const tableHeader = document.querySelector("#excelTable thead tr");
        const tableBody = document.querySelector("#excelTable tbody");

        // Clear previous table data
        tableHeader.innerHTML = '';
        tableBody.innerHTML = '';

        // Fill in the table header (first row)
        const headers = data[0];
        headers.forEach(header => {
            const th = document.createElement('th');
            th.innerText = header;
            tableHeader.appendChild(th);
        });

        // Fill in the table body (remaining rows)
        for (let i = 1; i < data.length; i++) {
            const row = document.createElement('tr');
            data[i].forEach(cell => {
                const td = document.createElement('td');
                td.innerText = cell;
                row.appendChild(td);
            });
            tableBody.appendChild(row);
        }

        // Show the table
        document.getElementById('excelTable').style.display = 'table';
    }

    // Check if there's a POST request
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        const selectedValue = "<?php echo htmlspecialchars($_POST['options']); ?>";
        loadExcel(selectedValue);
    <?php endif; ?>
</script>

</body>
</html>
