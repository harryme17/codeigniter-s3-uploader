<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S3 Secure Uploader</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .upload-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="upload-container">
        <div class="text-center mb-4">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/93/Amazon_Web_Services_Logo.svg/768px-Amazon_Web_Services_Logo.svg.png" alt="AWS Logo" width="72">
            <h2 class="mt-3">Secure File Uploader</h2>
            <p class="lead text-muted">Upload an image or zip file to a private S3 bucket.</p>
        </div>

        <!-- Validation Errors -->
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Validation Errors!</h4>
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- S3 Connection Errors -->
        <?php if (isset($s3_error)): ?>
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Upload Failed!</h4>
                <p>Could not connect to the S3 bucket. Please check your AWS configuration (.env file).</p>
                <hr>
                <p class="mb-0"><small><strong>Error Details:</strong> <?= esc($s3_error) ?></small></p>
            </div>
        <?php endif; ?>

        <!-- The Upload Form -->
        <?= form_open_multipart('uploader/do_upload', ['id' => 'uploadForm']) ?>
            <div class="mb-3">
                <label for="userfile" class="form-label">Select File</label>
                <input class="form-control" type="file" id="userfile" name="userfile" required>
                <div class="form-text">Max 10MB. Allowed types: png, jpg, jpeg, gif, zip.</div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                    <span class="btn-text">Upload to S3</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Simple script to show a spinner on submit -->
<script>
    document.getElementById('uploadForm').addEventListener('submit', function() {
        var submitBtn = document.getElementById('submitBtn');
        submitBtn.querySelector('.spinner-border').style.display = 'inline-block';
        submitBtn.querySelector('.btn-text').textContent = 'Uploading...';
        submitBtn.disabled = true;
    });
</script>

</body>
</html>