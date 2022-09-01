<?php
$cn = pg_connect("host=localhost port=5432 dbname=test-bash2 user=postgres password=pass");
if ($cn) {
    echo "<hr><br>";
    echo  "\n Connected to DB ";
    echo "<hr><br>";
} else {
    die("<br>Failed, reason: check db configurations.");
}
 

    $rq = "select * from airport;";
    $rq_result = pg_query($cn,$rq) or die("Something wrong..");
    while ($row = pg_fetch_assoc($rq_result)) {
        echo
        "<table border='1' frame=hsides rules=rows width='50%' cellspacing='1' style='text-align: center;'> 
        <thead>
        <th>Airport Code</th>
        <th>Airport Name</th>
        <th>Airport City</th>
        </thead>
        <tbody>
        <td>{$row['airport_code']}</td>
        <td>{$row['name']}</td>
        <td>{$row['city']}</td>
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
