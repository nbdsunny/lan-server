<?php
if(isset($_GET['file_path'])) {
    $filePath = $_GET['file_path'];
    if(is_dir($filePath)) {
        $directory = $filePath;
    } else if (file_exists($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
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

if(!isset($directory)) {
    $directory = $homeDirectory;
}

$files = scandir($directory);

?>
<form action="index.php" method="GET">
    <input type="submit" value="<?php echo $homeDirectory ?>" name="file_path"><hr>
</form>

<form action="index.php" method="GET">
<?php
foreach($files as $file) {
    if($file != "." && $file != "..") {
        $filePath = $directory.'\\'.$file;
        echo '<input type="submit" value="'.$filePath.'" name="file_path"><br><br>';
    }
}
?>
</form>

