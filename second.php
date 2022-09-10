<?php
$cn = pg_connect("host=localhost port=5432 dbname=flight_base user=postgres password=pass");
if ($cn) {
    echo "<hr><br>";
    echo  "\n Connected to DB ";
    echo "<hr><br>";
} else {
    die("<br>Failed, reason: check db configurations.");
}

$year = $_POST['dateForSecond'];


$sql = "select airport.city,count(ticket_no) as total_tickets from routes
    join flight_details on flight_details.flight_code = routes.flight_code
    join airport on airport.airport_code = flight_details.arrival_airport
    where routes.flight_code in (
    select flight_code from flight_details where departure_date between '$year-01-01' and '$year-12-31')
    group by airport.city
    order by  total_tickets desc
    limit 5;
    ";
$rq_result = pg_query($cn, $sql) or die("Something wrong.. maybe the flight doesn't exist for this data;");
while ($row = pg_fetch_assoc($rq_result)) {
    echo
    "<table border='1' frame=hsides rules=rows width='15%' cellspacing='1' style='text-align: center;'> 
            <thead>
            <th style='text-align:left;'>City</th>
            <th style='text-align:right;'>Total Tickets</th>
            </thead>
            <tbody>
            <td style='text-align:left;'>{$row['city']}</td>
            <td style='text-align:right;'>{$row['total_tickets']}</td>
            </tbody>
            </table>";
}

echo "
<br>
<br>
<br>
<br>
<a style='text-decoration: none; font-size: 35px; color:salmon; ' href='index.html'>Click here to go to the Home Page</a>";

pg_close($cn);

