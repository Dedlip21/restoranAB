<?php
require_once ('connect.php');
global  $yhendus;
if(isset($_REQUEST['lisamisvorm']) && !empty($_REQUEST['nimi']))
{
    $paring = $yhendus->prepare("INSERT INTO menuu(nimetus, kirjeldus, hind, kategooriaID) VALUES (?,?,?,?)");
    $paring->bind_param('ssdi', $_REQUEST['nimi'],$_REQUEST['kirje'],$_REQUEST[str_replace(',', '.','hind')],$_REQUEST['katID']);
    $paring->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
if(isset($_REQUEST['Kustuta']))
{
    $paring = $yhendus->prepare("DELETE FROM menuu where toodeID=?");
    $paring->bind_param('i', $_REQUEST['Kustuta']);
    $paring->execute();
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Restoran</title>
</head>
<body>
<h1>Restoran</h1>
<div id="meny">
    <ul>
        <?php
        $paring = $yhendus->prepare("SELECT toodeID, nimetus FROM menuu");
        $paring->bind_result($id,$nimi);
        $paring->execute();

        while($paring->fetch()) {
            echo "<li><a href='?id=$id'>$nimi</a></li>";
        }
        echo "</ul>";
        echo "<a href='?lisatoit=OK'>Lisa toit</a>";
        ?>
</div>
<div id="sisu">
    <?php
    if(isset($_REQUEST["id"])){
        $paring = $yhendus->prepare("SELECT toodeID, nimetus, kirjeldus, hind, kategooriaID FROM menuu WHERE toodeID=?");
        $paring->bind_param('i', $_REQUEST['id']);
        $paring->bind_result($id, $nimi, $kirjeldus, $hind, $kategooriaid);
        $paring->execute();
        /*$paring = $yhendus ->prepare("SELECT toodekategooria FROM kategooria WHERE kategooriaID = '$kategooriaid'");
        $paring->bind_result($kategooria);
        $paring->execute();*/
        if($paring->fetch()){
            echo "<div><strong>".htmlspecialchars($nimi)."</strong>";
            echo "<strong> ".htmlspecialchars($hind)."&#8364;</strong>";
            echo "<br>";
            echo "Kirjeldus: ".htmlspecialchars($kirjeldus);
            echo "<br><bu><a href='?Kustuta=$id'>Kustuta</a></bu>";
            echo "</div>";
        }
    }
    else if(isset($_REQUEST['lisatoit'])){
        ?>
    <h2>Uue toit lisamine</h2>
    <form name="uustoit" method="post" action="?">
        <input type="hidden" name="lisamisvorm">
        <input type="text" name="nimi" placeholder="Nimetus">
        <input type="text" name="kirje" placeholder="Kirjeldus">
        <input type="number" name="hind" placeholder="Hind" step="0.01">
        <input type="number" name="katID" placeholder="KategooriaID">
        <br>
        <input type="submit" value="OK">
    </form>
    <?php
    }
    else{
        echo "<h3>Siia tuleb toit info...</h3>";
    }
    ?>
</div>
</body>
</html>
<style>
    div#meny{
    padding: 3%;
    float: left;
    background-color: #818A7E;
    box-shadow: 5px 5px 0px 0px rgba(0,0,0,0.4);
    font-size: 20px;
    color: white;
}

div#sisu{
    padding-left: 3%;
    float: left;
    margin-left: 3%;
    border-left: solid 6px grey;
    font-size: 18px;
}
a
{
    color: #272991;
}
img{
    width: 400px;
    height: 400px;
    border: 5pt solid #818A7E;
}
bu{
    text-decoration: none;
    color: black;
    outline: 2px solid black;
}
input[type='text'], input[type='number'], textarea
{
    width: 300px;
    height: 20px;
    border: 2pt solid black;
    font-size: 16px;
}
</style>