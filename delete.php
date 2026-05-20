<?php
$uploadDir = "uploads/";
$allowedExtensions = ["jpg", "jpeg", "png", "gif", "webp"];

if (!isset($_GET["file"])) {
    header("Location: galeri.php?status=error&message=" . urlencode("File tidak ditemukan."));
    exit;
}

$file = basename($_GET["file"]);
$filePath = $uploadDir . $file;
$fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

if (file_exists($filePath) && in_array($fileExtension, $allowedExtensions)) {
    unlink($filePath);
    header("Location: galeri.php?status=success&message=" . urlencode("Foto berhasil dihapus."));
    exit;
} else {
    header("Location: galeri.php?status=error&message=" . urlencode("File tidak valid atau tidak ditemukan."));
    exit;
}
?>