<!DOCTYPE html>
<link href="style.css" rel="stylesheet">
<body>
    <div class="header">
        <h1>NHL Stenden Kentekencheck</h1>
    </div>
    <div>
        <div class="balkje">
        </div>
        <div class="content">
            <?php
            $response = file_get_contents('http://localhost:8000/json/voertuigen/' . $_GET["kenteken"]);
            $array = (json_decode($response));
            echo '<pre>'; print_r($array); echo '</pre>';
            ?>
        </div>
        <div class="balkje">
        </div>
    </div>

    <div class="header">
    </div>
</body>