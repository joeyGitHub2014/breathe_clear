<?php
$nonce = uniqid();

header("Content-Security-Policy-Report-Only: default-src report-uri  'self' 'nonce-$nonce'");


/*
CSP refferes  to protocal domain and port of the current page

self -> only from current orgin - inline will not work - is a constant value

defasult connect-src img-src media-src script-src style-src

CSP 2 Directives
base-uri child-src form-action frame-ancestors plugin-types
*/

require_once("../includes/initialize.php");

$patient = new Patient();
$patient2 = new Patient();


$antonerPatient = clone $patient;

if ($antonerPatient === $patient){
    $antonerPatient->test(6);
    echo 'after change $antonerPatient->test(6) ==> '.$antonerPatient->testit;
    echo "<br/>";

    echo ' $patient ==> '.$patient->testit;

}else{
    $antonerPatient->test(6);
    echo 'after change $antonerPatient->test(6) ==> '.$antonerPatient->testit;
    echo PHP_EOL;

    echo ' $patient ==> '.$patient->testit;
    //echo 'They are dulicates.';
}

echo PHP_EOL;

$antonerPatient = $patient;

if ($antonerPatient === $patient){
   // echo 'They are aliases.';
}else{
  //  echo 'They are dulicates.';
}

?>
<DOCTYPE html>
<html>

    <script nonce="<?php echo $nonce?>">
        alert(1);
    </script>

    <head>

    </head>

    <body>
    </body>

</html>







