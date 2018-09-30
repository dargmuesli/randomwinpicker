<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <title>
            Error <?php echo $_GET['code']; ?> [randomwinpicker.de]
        </title>
        <link rel="icon" href="<?php echo 'https://' . $_SERVER['SERVER_NAME'] . '/layout/icons/favicon.ico'; ?>" type="image/png" />
        <link rel="stylesheet" href="<?php echo 'https://' . $_SERVER['SERVER_NAME'] . '/layout/stylesheets/fonts.php'; ?>">
        <link rel="stylesheet" href="<?php echo 'https://' . $_SERVER['SERVER_NAME'] . '/layout/stylesheets/style.css'; ?>">
        <link rel="stylesheet" href="<?php echo 'https://' . $_SERVER['SERVER_NAME'] . '/layout/stylesheets/error.css'; ?>">
    </head>
    <body>
        <header>
            <a href="<?php if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') {
    echo $_SERVER['HTTP_REFERER'];
} else {
    echo 'index.php';
} ?>" title="Back" id="back">
                <img src="<?php echo 'https://' . $_SERVER['SERVER_NAME'] . '/layout/icons/arrow.png'; ?>" alt="Arrow" class="rotate"/>
            </a>
        </header>
        <main>
            <div>
                <h1>
                    Error <?php echo $_GET['code']; ?>
                </h1>
<?php    switch ($lang) {
case 'de':    ?>
                <p>
                    Schau was du angerichtet hast! Das ist eine Sonneneruption...
                </p>
<?php        break;
default:    ?>
                <p>
                    Look what you've done! That is a sun eruption...
                </p>
<?php         break;
}    ?>
            </div>
        </main>
        <footer>
        </footer>
    </body>
</html>
