<pre>

<?php

var_dump($_FILES);

$employeeId = "123";

const MAX_UPLOAD_SIZE = 100 * 1024;

if ($_FILES["my-file"]["size"] > MAX_UPLOAD_SIZE) {
    print 'file is too large.';

    exit();
}

$extension = pathinfo($_FILES["my-file"]["name"], PATHINFO_EXTENSION);

$path = sprintf("./%s.%s", $employeeId, $extension);

print $path;

move_uploaded_file($_FILES["my-file"]["tmp_name"], $path);
