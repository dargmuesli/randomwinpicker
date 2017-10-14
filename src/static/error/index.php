<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <title>
            Error <?php echo $_GET['code']; ?> [randomwinpicker.de]
        </title>
        <link rel="icon" href="<?php echo 'https://' . $_SERVER['SERVER_NAME'] . '/layout/icons/favicon.ico'; ?>" type="image/png" />
        <link rel="stylesheet" href="<?php echo 'https://' . $_SERVER['SERVER_NAME'] . '/layout/stylesheets/fonts.css'; ?>">
        <link rel="stylesheet" href="<?php echo 'https://' . $_SERVER['SERVER_NAME'] . '/layout/stylesheets/style.css'; ?>">
        <style type="text/css">
            main {
                position: fixed;
                width: 100%;
                height: 100%;
                top: 0;

                background-image: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url(<?php echo $_SERVER['SERVER_ROOT_URL']; ?>/layout/icons/eruption.jpg);
                background-size: cover;
                font-size: 200%;
            }
            main div {
                height: 100%;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-65%, -30%);
            }
            header a {
                z-index: 1;
            }
        </style>
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
