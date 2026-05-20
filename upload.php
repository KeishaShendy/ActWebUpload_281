<?php
$uploadDir = "uploads/";
$allowedExtensions = ["jpg", "jpeg", "png", "gif", "webp"];
$allowedMimeTypes = ["image/jpeg", "image/png", "image/gif", "image/webp"];
$maxFileSize = 2 * 1024 * 1024; // 2MB

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!isset($_POST["upload"])) {
    header("Location: index.html");
    exit;
}

if (!isset($_FILES["fileToUpload"]) || $_FILES["fileToUpload"]["error"] !== UPLOAD_ERR_OK) {
    header("Location: galeri.php?status=error&message=" . urlencode("Upload gagal. File tidak terbaca."));
    exit;
}

$fileName = $_FILES["fileToUpload"]["name"];
$fileTmp = $_FILES["fileToUpload"]["tmp_name"];
$fileSize = $_FILES["fileToUpload"]["size"];
$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

if (!in_array($fileExtension, $allowedExtensions)) {
    header("Location: galeri.php?status=error&message=" . urlencode("Upload gagal. Hanya file foto yang diperbolehkan."));
    exit;
}

if ($fileSize > $maxFileSize) {
    header("Location: galeri.php?status=error&message=" . urlencode("Upload gagal. Ukuran file maksimal 2MB."));
    exit;
}

if (getimagesize($fileTmp) === false) {
    header("Location: galeri.php?status=error&message=" . urlencode("Upload gagal. File yang dipilih bukan gambar."));
    exit;
}

$mimeType = mime_content_type($fileTmp);

if (!in_array($mimeType, $allowedMimeTypes)) {
    header("Location: galeri.php?status=error&message=" . urlencode("Upload gagal. Tipe file tidak valid."));
    exit;
}

$safeName = preg_replace("/[^a-zA-Z0-9._-]/", "_", basename($fileName));
$newFileName = date("Ymd_His") . "_" . $safeName;
$targetFile = $uploadDir . $newFileName;

if (move_uploaded_file($fileTmp, $targetFile)) {
    header("Location: galeri.php?status=success&message=" . urlencode("Foto berhasil diupload."));
    exit;
} else {
    header("Location: galeri.php?status=error&message=" . urlencode("Foto gagal disimpan."));
    exit;
}
?>