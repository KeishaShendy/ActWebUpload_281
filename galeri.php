<?php
$uploadDir = "uploads/";
$allowedExtensions = ["jpg", "jpeg", "png", "gif", "webp"];
$images = [];

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$files = array_diff(scandir($uploadDir), [".", ".."]);

foreach ($files as $file) {
    $filePath = $uploadDir . $file;
    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

    if (is_file($filePath) && in_array($extension, $allowedExtensions)) {
        $images[] = $file;
    }
}

$status = isset($_GET["status"]) ? $_GET["status"] : "";
$message = isset($_GET["message"]) ? $_GET["message"] : "";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Galeri Foto</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #dbeafe, #f8fafc);
            color: #0f172a;
        }

        .wrapper {
            width: 92%;
            max-width: 1150px;
            margin: 40px auto;
        }

        .header {
            background: white;
            padding: 35px;
            border-radius: 26px;
            text-align: center;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.1);
            margin-bottom: 30px;
        }

        h1 {
            font-size: 38px;
            margin: 0 0 10px;
        }

        p {
            color: #64748b;
        }

        .message {
            max-width: 650px;
            margin: 20px auto;
            padding: 14px 18px;
            border-radius: 14px;
            font-weight: bold;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn {
            display: inline-block;
            border: none;
            padding: 11px 18px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-download {
            background: #16a34a;
            color: white;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 24px;
        }

        .photo-card {
            background: white;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.1);
        }

        .photo-card img {
            width: 100%;
            height: 210px;
            object-fit: cover;
            display: block;
        }

        .photo-info {
            padding: 16px;
        }

        .photo-name {
            font-size: 14px;
            font-weight: bold;
            color: #334155;
            word-break: break-all;
            margin-bottom: 14px;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .empty {
            background: white;
            padding: 45px;
            text-align: center;
            border-radius: 22px;
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.1);
            color: #64748b;
        }
    </style>
</head>
<body>

<div class="wrapper">

    <div class="header">
        <h1>Galeri Foto</h1>
        <p>Foto yang sudah diupload dapat dilihat, diunduh, dan dihapus.</p>

        <?php if ($message != ""): ?>
            <div class="message <?php echo htmlspecialchars($status); ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <a href="index.html" class="btn btn-primary">Upload Foto Baru</a>
    </div>

    <?php if (count($images) > 0): ?>
        <div class="gallery">
            <?php foreach ($images as $image): ?>
                <?php
                    $safeImage = htmlspecialchars($image);
                    $imageUrl = $uploadDir . rawurlencode($image);
                ?>

                <div class="photo-card">
                    <img src="<?php echo $imageUrl; ?>" alt="<?php echo $safeImage; ?>">

                    <div class="photo-info">
                        <div class="photo-name">
                            <?php echo $safeImage; ?>
                        </div>

                        <div class="actions">
                            <a href="<?php echo $imageUrl; ?>" download class="btn btn-download">
                                Unduh
                            </a>

                            <a 
                                href="delete.php?file=<?php echo urlencode($image); ?>" 
                                class="btn btn-delete"
                                onclick="return confirm('Yakin ingin menghapus foto ini?');"
                            >
                                Hapus
                            </a>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty">
            Belum ada foto yang diupload.
        </div>
    <?php endif; ?>

</div>

</body>
</html>