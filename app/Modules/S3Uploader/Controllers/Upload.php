<?php

namespace App\Modules\S3Uploader\Controllers;

use App\Controllers\BaseController;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class Upload extends BaseController
{
    private $s3;
    private $bucketName;

    /**
     * Constructor to initialize the S3 Client
     */
    public function __construct()
    {
        // Get our credentials from the .env file
        $this->bucketName = getenv('S3_BUCKET_NAME');

        // Create a new S3Client
        $this->s3 = new S3Client([
            'version'     => 'latest',
            'region'      => getenv('AWS_REGION'),
            'credentials' => [
                'key'    => getenv('AWS_ACCESS_KEY_ID'),
                'secret' => getenv('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
    }

    /**
     * Shows the main upload form page
     */
    public function index()
    {
        // Load the form helper so the view can use form_open_multipart()
        helper('form'); // <-- ADD THIS LINE

        // Just load the view
        return view('App\Modules\S3Uploader\Views\upload_form');
    }


    /**
     * Handles the file upload to S3 and generates the temporary URL
     */
    public function do_upload()
    {
        // Also load the helper here, in case validation fails
        helper('form'); // <-- ADD THIS LINE

        // 1. Set up validation rules
        $validationRule = [
            'userfile' => [
                'label' => 'Image or Zip File',
                'rules' => [
                    'uploaded[userfile]',
                    'max_size[userfile,10240]',
                    'ext_in[userfile,png,jpg,jpeg,gif,zip]',
                ],
            ],
        ];


        // 2. Run validation
        if (! $this->validate($validationRule)) {
            // If validation fails, show the form again with the errors
            $data['errors'] = $this->validator->getErrors();
            return view('App\Modules\S3Uploader\Views\upload_form', $data);
        }

        // 3. If validation passes, get the file
        $file = $this->request->getFile('userfile');
        $fileName = 'uploads/' . $file->getRandomName(); // Create a unique name in an 'uploads' folder

        // 4. Upload to S3 inside a try-catch block
        try {
            // putObject is the command to upload a file
            $this->s3->putObject([
                'Bucket' => $this->bucketName,
                'Key'    => $fileName,
                'Body'   => fopen($file->getTempName(), 'r'),
                'ACL'    => 'private', // We use a presigned URL, so the object itself remains private
            ]);

            // 5. Create a command to get the object
            $cmd = $this->s3->getCommand('GetObject', [
                'Bucket' => $this->bucketName,
                'Key'    => $fileName,
            ]);

            // 6. Create a pre-signed URL that is valid for 5 minutes
            $presignedRequest = $this->s3->createPresignedRequest($cmd, '+5 minutes');
            
            // Get the actual URL string
            $data['presignedUrl'] = (string) $presignedRequest->getUri();
            $data['fileExtension'] = $file->getExtension(); // Pass extension to view

            // 7. Load the success view and pass it the URL
            return view('App\Modules\S3Uploader\Views\upload_success', $data);

        } catch (S3Exception $e) {
            // If the upload fails, catch the error and show it
            $data['s3_error'] = $e->getMessage();
            return view('App\Modules\S3Uploader\Views\upload_form', $data);
        }
    }
}