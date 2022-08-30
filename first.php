<?php
$cn = pg_connect("host=localhost port=5432 dbname=test-bash user=postgres password=pass");
if ($cn) {
    echo "<hr><br>";
    echo  "\n Connected to DB ";
    echo "<hr><br>";
} else {
    die("<br>Failed, reason: check db configurations.");
}

$departure_date = $_POST['departure_date'];

if($departure_date){
    $rq = "select flight_code from flight_details where departure_date='$departure_date'";
    $rq_result = pg_query($cn,$rq) or die("Something wrong.. maybe the flight doesn't exist for this data;");
    $rq_final = pg_fetch_assoc($rq_result);
    if($rq_final){
        $sql = "select passenger.name,passenger.surname,booking.book_date
                from routes
                join ticket on ticket.ticket_no = routes.ticket_no
                join passenger on passenger.passenger_id = ticket.passenger_id
                join booking on booking.book_ref = routes.book_ref
                where flight_code in (
                '{$rq_final['flight_code']}'
                    );";
        $findBookDateAndPassenger = pg_query($cn,$sql) or die("Something  wrong... probably wrong data.");
        while ($row = pg_fetch_assoc($findBookDateAndPassenger)) {
            echo
            "<table border='1' frame=hsides rules=rows width='50%' cellspacing='1' style='text-align: center;'> 
            <thead>
            <th>Passenger Name</th>
            <th>Passenge Surname</th>
            <th>Booking Date</th>
            </thead>
            <tbody>
            <td>{$row['name']}</td>
            <td>{$row['surname']}</td>
            <td>{$row['book_date']}</td>
            </tbody>
            </table>";
    }
    }else{
        echo "Sorry not flights records found for this data!";
    }
} else {
    echo "Please give me corresponding data:    <br>
    Like the Example above:                     <br>
                                                <hr>
             Departure Date = '2022-08-15'      <br>
             Departure Airport = 'CRT'          <br>
             Arrival Airport = 'ATH' 
             <hr> ";
}

echo "
<br>
<br>
<br>
<br>
<a style='text-decoration: none; font-size: 35px; color:salmon; ' href='index.html'>Click here to go to the Home Page</a>";

pg_close($cn);
