<?php
    header('Content-Type: application/javascript');

    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/dotenv.php';

    $dbh = new PDO('pgsql:host='.$_ENV['PGSQL_HOST'].';port='.$_ENV['PGSQL_PORT'].';dbname='.$_ENV['PGSQL_DATABASE'], $_ENV['PGSQL_USERNAME'], $_ENV['PGSQL_PASSWORD']);

    $encoding = 'UTF-8';

    if (isset($email)) {
        $stmt = $dbh->prepare("SELECT encoding FROM accounts WHERE mail='" . $email . "'");

        if (!$stmt->execute()) {
            throw new Exception($stmt->errorInfo()[2]);
        }

        $encoding = $stmt->fetch()[0];
    }
?>
//<script>
var data;

function handleFileSelect(evt, enc) {
    var file = evt.target.files[0];

    Papa.parse(file, {
        header: true,
        dynamicTyping: true,
        encoding: enc,
        complete: function(results) {
            if (results.errors[0] != null) {
                alert(results.errors[0].message);
            }

            reset(2, 'participants');
            editing = true;

            for (var i = 0; i < results.data.length; i++) {
                if (i == results.data.length - 1) {
                    editing = false;
                }

                document.getElementById('tableInput0').value = results.data[i].username;
                document.getElementById('tableInput1').value = results.data[i].quantity;
                document.getElementById('add').click();
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    var csvfile = document.getElementById('csv-file');
    if (csvfile != null) {
        csvfile.onchange = function(event) {handleFileSelect(event, '<?php echo $encoding; ?>');};
    }
});
//</script>
