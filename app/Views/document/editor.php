<?php

$data = $_GET;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/sb-admin-2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/style.css" />
    <title>Hello, world!</title>
</head>

<body>
    <header class="bg-secondary py-1 mb-3 fixed-top">
        <div class="container">
            <div class="d-flex justify-content-end">
                <button type="submit" id="save" class="btn btn-primary">Tanda Tangani</button>
            </div>
        </div>
    </header>
    <div class="container-fluid mt-5">
        <form action="" method="post">
            <input type="hidden" name="filename" id="fileName" value="<?= $data['name'] ?>">
            <input type="hidden" name="documentID" id="documentID" value="<?= $data['id'] ?>">
        </form>
        <div id="documentRender" class="border">
            <img id="drag" width="100" height="50" src="/uploads/signature/<?= user()->signature ?>" alt="" />
        </div>
    </div>

    <script src="<?= base_url() ?>/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.10.377/build/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/script.js"></script>
</body>

</html>