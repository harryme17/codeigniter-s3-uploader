# CodeIgniter 4 Secure S3 Uploader

[![Built with CodeIgniter 4](https://img.shields.io/badge/Built%20with-CodeIgniter%204-EF4423.svg?style=flat-square&logo=codeigniter)](https://codeigniter.com)

A simple yet powerful web application built with CodeIgniter 4 that demonstrates how to securely upload files (images, zips) to a private AWS S3 bucket. Access to the uploaded files is provided via temporary, expiring presigned URLs, ensuring that the files in the bucket remain private and secure.

The user interface is built with Bootstrap 5 for a clean, modern, and responsive experience.

---

## Features

-   **Secure File Uploads:** Files are sent directly to a private S3 bucket.
-   **Private by Default:** The S3 bucket is configured to block all public access.
-   **Temporary Access:** Generates a short-lived (5-minute) **presigned URL** for the user to view or download their file.
-   **HMVC Architecture:** Organized into a `S3Uploader` module for clean separation of concerns.
-   **Modern UI:** A clean and responsive user interface powered by Bootstrap 5.
-   **Validation:** Server-side validation for file size and type.
-   **Clear Feedback:** Provides a loading spinner during upload and clear success/error messages.

## How It Works

The core security model relies on AWS IAM credentials and S3 Presigned URLs.

1.  The user selects a file and submits the form.
2.  The CodeIgniter backend validates the file.
3.  The application, using its secure IAM credentials, uploads the file object to the **private** S3 bucket.
4.  After a successful upload, the application requests a special **presigned URL** from AWS S3 for that specific file.
5.  This URL contains a temporary authentication token and an expiration time.
6.  The user is given this temporary URL, allowing them to access the file for a limited time, even though the bucket itself is not public.

---

## Prerequisites

Before you begin, ensure you have the following installed:

-   PHP (version 8.0 or higher recommended)
-   Composer
-   An AWS Account with a configured S3 Bucket and an IAM user with S3 permissions.

## Setup and Installation

Follow these steps to get the project running on your local machine.

**1. Clone the repository:**
```bash
git clone https://github.com/YOUR_USERNAME/codeigniter-s3-uploader.git
cd codeigniter-s3-uploader
