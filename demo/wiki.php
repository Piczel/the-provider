<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Demo wiki | The Provider</title>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery.json-editor.min.js"></script>
    <script src="js/ajax.js"></script>

    <link rel="stylesheet" href="css/json.css">
</head>
<body>

    <?php include 'header.html'; ?>

    <select name="json-template">
        <option value="">- Välj förfrågan -</option>
        <option action="../generate-token.php" value='{"username":"","password":""}'>generate-token.php</option>
        <?php
            $json_path = '../wiki/json/request/';
            $php_path = '../wiki/php/';
            if($handle = opendir($json_path))
            {
                while (false !== ($entry = readdir($handle)))
                {
                    if ($entry != "." && $entry != "..")
                    {
                        echo '<option action="'. $php_path.substr($entry, 0, strrpos($entry, '.', -1)).'.php' .'" value=\''. file_get_contents($json_path.$entry) .'\'>'. $entry .'</option>';
                    }
                }
                closedir($handle);
            }
        ?>
    </select>

    <div class="form temp">
        <input type="text" name="accountID" placeholder="accountID">
        <br>
        <br>
        <input type="text" name="token" placeholder="token">
        <br>
        <br>
        <input type="text" name="wikiID" placeholder="wikiID">
    </div>

    <div class="main">
        <div class="in">
            <h2>Förfrågan</h2>
            <div class="form request"></div>

            <button class="submit">Skicka</button>
        
        </div>
        <div class="out">
            <h2>Svar</h2>
            <div class="form response"></div>
        </div>
    </div>

    
    <script src="js/demo.js"></script>
</body>
</html>