<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graph Generator</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <h2>Enter Data to Generate Graph</h2>

    <form id="graphForm">
        <label for="input1">host:</label>
        <input type="text" id="host" name="host" required><br><br>

        <label for="input2">database:</label>
        <input type="text" id="database" name="database" required><br><br>

        <label for="input3">username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="input4">password:</label>
        <input type="text" id="password" name="password"><br><br>

        <label for="inputData">Quary:</label><br>
        <textarea id="query" name="query" rows="5" cols="50" required>SELECT MONTH(sale_date) AS SaleMonth,
            COUNT(id) AS TotalSalesCount,
            SUM(quantity) AS TotalQuantitySold,
            AVG(quantity) AS AverageQuantityPerSale
        FROM
            sales
        GROUP BY
            MONTH(sale_date)
        ORDER BY
            MONTH(sale_date)</textarea><br><br>

        <button type="submit">Generate Graph</button>
    </form>

    <div id="graphContainer" style="margin-top: 20px; width: 600px;">
        <div id="chart_div" style="width: 100%; height: 500px;"></div>
        <canvas id="myChart" width="600" height="400"></canvas>
    </div>

    <script>
        document.getElementById('graphForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            // Extract form data
            var host = formData.get('host');
            var database = formData.get('database');
            var username = formData.get('username');
            var password = formData.get('password');
            var query = formData.get('query');

            // Perform AJAX request to generate graph
            fetch('/generate-graph', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        host,
                        database,
                        username,
                        password,
                        query
                    })
                })
                .then(response => response.json())
                .then(data => {
                    drawChart(data)
                });
             
        });

        function renderGraph(data) {

        }
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart(result) {
            var data = google.visualization.arrayToDataTable(
                result
            );

            var options = {
                title: 'Company Performance',
                hAxis: {
                    title: 'Month',
                    titleTextStyle: {
                        color: '#333'
                    }
                },
                vAxis: {
                    minValue: 0
                }
            };

            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
</body>

</html>
