<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Lan Server</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <?php
    if (isset($_GET['file_path'])) {
        $filePath = $_GET['file_path'];

        if (is_dir($filePath)) {
            $directory = $filePath;
        } else if (file_exists($filePath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        }
    }

    $data = file_get_contents('shortcut.lnk');
    $homeDirectory = preg_replace('@^.*\00([A-Z]:)(?:[\00\\\\]|\\\\.*?\\\\\\\\.*?\00)([^\00]+?)\00.*$@s', '$1\\\\$2', $data);

    if (!isset($directory)) {
        $directory = $homeDirectory;
    }

    $files = scandir($directory);

    ?>
    <div class="jumbotron">
        <form action="index.php" method="GET">
            <input type="hidden" name="file_path" value="<?php echo $homeDirectory; ?>">
            <button type="submit" class="btn btn-primary"><?php echo $homeDirectory; ?></button>
            <hr>
        </form>

        <?php
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                $filePath = $directory . '\\' . $file;
                ?>
                <form action="index.php" method="GET">
                    <input type="hidden" name="file_path" value="<?php echo $filePath; ?>">
                    <button class="btn btn-primary"><?php echo $filePath; ?></button>
                </form>
                <br><br>
                <?php
            }
        }
        ?>
    </div>
</div>
</body>
</html>