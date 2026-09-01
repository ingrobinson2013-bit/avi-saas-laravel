<?php

require __DIR__ . '/vendor/autoload.php';

use Aws\S3\S3Client;

$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'auto',
    'endpoint' => 'https://2413fc82c40ce4e9e45392c3186b4cd0.r2.cloudflarestorage.com',
    'credentials' => [
        'key'    => '04b8a225258383790f4be649ad5bf06b',
        'secret' => 'c73f5ce7cffd9d210ddfcbadf339db5225572cce653a649a5a77c1f86ac2badd',
    ],
    'use_path_style_endpoint' => true,
]);

try {
    $result = $s3->putBucketCors([
        'Bucket' => 'avi-plan-assets',
        'CORSConfiguration' => [
            'CORSRules' => [
                [
                    'AllowedHeaders' => ['*'],
                    'AllowedMethods' => ['GET', 'PUT', 'POST', 'HEAD', 'DELETE'],
                    'AllowedOrigins' => ['*'],
                    'ExposeHeaders'  => ['ETag'],
                    'MaxAgeSeconds'  => 3600,
                ],
            ],
        ],
    ]);
    echo "CORS_CONFIGURED_SUCCESSFULLY_ON_R2_BUCKET\n";
} catch (Exception $e) {
    echo "CORS_ERROR: " . $e->getMessage() . "\n";
}
