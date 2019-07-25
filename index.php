<?php
if(isset($_POST['file_path'])) {
    $filePath = $_POST['file_path'];
    if (file_exists($filePath)) {
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

$link =  'shortcut.lnk';
$data = file_get_contents($link);
$dir = preg_replace('@^.*\00([A-Z]:)(?:[\00\\\\]|\\\\.*?\\\\\\\\.*?\00)([^\00]+?)\00.*$@s', '$1\\\\$2', $data);
$files = scandir($dir);

?>
<form action="index.php" method="POST">
<?php
foreach($files as $file) {
    $filePath = $dir.'\\'.$file;
    echo '<input type="submit" value="'.$filePath.'" name="file_path"><br><br>';
}
?>
</form>

