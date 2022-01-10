<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<?= helper('auth') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tanda Tangan Sendiri</h1>
    <div class="border rounded p-3">
        <form method="POST" enctype="multipart/form-data" action="<?= route_to('self-sign') ?>">

            <div class="mb-3">
                <label for="signer_name" class="form-label">Judul Dokumen</label>
                <input type="text" class="form-control <?= $validator->getError('document_title') ? 'is-invalid' : '' ?>" id="document_title" name="document_title">
                <div class="invalid-feedback">
                    <?= $validator->getError('document_title') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Dokumen</label>
                <div class="custom-file">
                    <input type="file" accept="application/pdf" name="document" id="document" class="custom-file-input <?= $validator->getError('document') ? 'is-invalid' : '' ?> " id="validatedCustomFile" required onchange="loadFileName()">
                    <label class="custom-file-label" id="documentLabel" for="validatedCustomFile">Choose file...</label>
                    <div class="invalid-feedback">
                        <?= $validator->getError('document') ?>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-warning">Reset</button>
        </form>
        <script>
            function loadFileName() {
                var file = document.querySelector('#document');
                var label = document.querySelector('#documentLabel');

                label.textContent = file.files[0].name;
            }
        </script>
    </div>
</div>
<?= $this->endSection() ?>