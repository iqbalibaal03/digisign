<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Undang Pihak Lain</h1>
    <div class="border rounded p-3">
        <form method="POST" enctype="multipart/form-data" action="<?= route_to('invite-friend') ?>">

            <div class="mb-3">
                <label for="signer_name" class="form-label">Judul Dokumen</label>
                <input type="text" class="form-control <?= $validator->getError('document_title') ? 'is-invalid' : '' ?>" id="document_title" name="document_title">
                <div class="invalid-feedback">
                    <?= $validator->getError('document_title') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Pilih Pihak Lain</label>
                <input class="form-control" list="datalistOptions" id="userId" placeholder="Ketik untuk mencari">
                <datalist id="datalistOptions">
                    <?php foreach ($users as $user) : ?>
                        <?php if ($user->id != user_id()) : ?>
                            <option data-value="<?= $user->id ?>"><?= $user->name ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </datalist>
                <input type="hidden" name="to_id" id="userId-hidden">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Dokumen</label>
                <div class="custom-file">
                    <input type="file" accept="application/pdf" name="document" id="document" class="custom-file-input <?= $validator->getError('document') ? 'is-invalid' : '' ?> " onchange="loadFileName()">
                    <label class="custom-file-label" id="documentLabel">Choose file...</label>
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

            document.querySelector('input[list]').addEventListener('input', function(e) {
                var input = e.target,
                    list = input.getAttribute('list'),
                    options = document.querySelectorAll('#' + list + ' option'),
                    hiddenInput = document.getElementById(input.getAttribute('id') + '-hidden'),
                    inputValue = input.value;

                hiddenInput.value = inputValue;

                for (var i = 0; i < options.length; i++) {
                    var option = options[i];

                    if (option.innerText === inputValue) {
                        hiddenInput.value = option.getAttribute('data-value');
                        break;
                    }
                }
            });
        </script>
    </div>
</div>
<?= $this->endSection() ?>