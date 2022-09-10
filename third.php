<?php
$cn = pg_connect("host=localhost port=5432 dbname=flight_base user=postgres password=pass");
if ($cn) {
    echo "<hr><br>";
    echo  "\n Connected to DB ";
    echo "<hr><br>";
} else {
    die("<br>Failed, reason: check db configurations.");
}

$code = $_POST['aircraft_code'];
$name = $_POST['aircraft_name'];
$capacity = $_POST['aircraft_capacity'];
$range = $_POST['aircraft_range'];
$btn_value = $_POST['btn-value'];


if ($btn_value == 'showall') {
    $rq = "select * from aircraft;";
    $rq_result = pg_query($cn, $rq) or die("Something wrong..");
    while ($row = pg_fetch_assoc($rq_result)) {
        echo
        "<table border='1' frame=hsides rules=rows width='50%' cellspacing='1' style='text-align: center;'> 
        <thead>
        <th>Aircraft Code</th>
        <th>Aircraft Name</th>
        <th>Aircraft Capacity</th>
        <th>Aircraft Distance</th>
        </thead>
        <tbody>
        <td>{$row['aircraft_code']}</td>
        <td>{$row['name']}</td>
        <td>{$row['capacity']}</td>
        <td>{$row['range']}</td>
        </tbody>
        </table>";
    }
}


if ($btn_value == 'saveupdate') {

    $sql = "insert into aircraft(aircraft_code,name,capacity,range)
values ('$code','$name','$capacity','$range') on conflict(aircraft_code) do update set name = excluded.name, capacity = excluded.capacity, range = excluded.range;";
    $rs = pg_query($cn, $sql) or die("Cannot execute query, probably because you try to save the same user twice. : $sql\n");


    if ($rs == true) {
        echo "Aircraft with code  :" . $code . " " . $name  . " saved succesfully.";
    }
}


if ($btn_value == 'deleteAir') {
    $del = "delete from aircraft where aircraft_code = $code;";
    $del_result = pg_query($cn, $del) or die("Something wrong..");

    if($del_result == true){
        echo "aicraft = $code deleted successfully!!";
    }  
}

echo "
<br>
<br>
<br>
<br>
<a style='text-decoration: none; font-size: 35px; color:salmon; ' href='index.html'>Click here to go to the Home Page</a>";


pg_close($cn);
