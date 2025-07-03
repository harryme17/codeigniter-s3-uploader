<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Successful</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .success-container {
            max-width: 700px;
            margin: 50px auto;
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .preview-img {
            max-width: 100%;
            height: auto;
            border: 1px solid #dee2e6;
            padding: 0.25rem;
            border-radius: 0.25rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="success-container text-center">
        <h2 class="text-success">✅ Upload Successful!</h2>
        <p class="lead">Your file has been securely uploaded to Amazon S3.</p>
        
        <div class="alert alert-warning mt-4" role="alert">
            <strong>Important:</strong> The link below is temporary and will expire in <strong>5 minutes</strong>. After that, it will become invalid.
        </div>

        <?php if (isset($presignedUrl)): ?>
            <div class="card mt-4">
                <div class="card-header">
                    Your File
                </div>
                <div class="card-body">
                    <?php if (in_array($fileExtension, ['png', 'jpg', 'jpeg', 'gif'])): ?>
                        <h5 class="card-title">Image Preview</h5>
                        <img src="<?= esc($presignedUrl, 'attr') ?>" class="preview-img mb-3" alt="Uploaded Image Preview">
                        <a href="<?= esc($presignedUrl, 'attr') ?>" class="btn btn-secondary" target="_blank">View in New Tab</a>
                    <?php else: ?>
                        <h5 class="card-title">Download Your ZIP File</h5>
                        <p class="card-text">Your file is ready for download.</p>
                        <a href="<?= esc($presignedUrl, 'attr') ?>" class="btn btn-success btn-lg">Download .zip File</a>
                    <?php endif; ?>
                </div>
                <div class="card-footer text-muted">
                    Link expires in 5 minutes.
                </div>
            </div>
        <?php endif; ?>

        <hr class="my-4">
        
        <a href="<?= site_url('uploader') ?>" class="btn btn-outline-primary">Upload Another File</a>

    </div>
</div>

</body>
</html>