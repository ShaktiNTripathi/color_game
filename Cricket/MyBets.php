<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bet History</title>
    <style>
        /* Your CSS styles */
        .table-container {
            overflow-x: auto; /* Allow horizontal scroll */
            margin-left: 20px;
            margin-right: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            white-space: nowrap; /* Prevent text wrapping */
        }

        th {
            background-color: #f2f2f2;
        }

        @media (max-width: 768px) {
            /* Responsive CSS for smaller screens */
            .table-container {
                overflow-x: auto;
                margin-left: 0;
                margin-right: 0;
            }

            table {
                width: 100%;
                overflow-x: auto;
            }

            th, td {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }
    </style>
</head>
<body>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Match Name</th>
                <th>Bet On</th>
                <th>Result</th>
                <th>Bet Amount</th>
                <th>Winning Amount</th>
                <th>Date</th> <!-- Add the Date column back in -->
            </tr>
        </thead>
        <tbody id="bet-history">
            <!-- Bet history will be populated here dynamically -->
        </tbody>
    </table>
</div>

</body>
</html>
