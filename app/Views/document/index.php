<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1 class="text-gray-800">Dokumen Saya</h1>
        </div>

    </div>
    <div class="row">
        <div class="col">
            <form action="<?= base_url() ?>/mydocuments" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="keyword" class="form-control" style="height: 38px;" placeholder="Cari dokumen" aria-label="Cari dokumen" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Cari</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col">
            <form action="<?= base_url() ?>/mydocuments" method="post">
                <div class="input-group">
                    <select name="sort_by" class="custom-select" aria-label="Example select with button addon">
                        <option value="">Urut sebagai...</option>
                        <option value="document_title">Judul Dokumen</option>
                        <option value="created_at">Tanggal</option>
                    </select>
                    <select name="sort_format" class="custom-select" aria-label="Example select with button addon">
                        <option>Choose...</option>
                        <option value="ASC">ASC</option>
                        <option value="DESC">DESC</option>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col text-right">
            <button id="modalButton" data-toggle="modal" data-target="#deleteDocument" class="btn btn-danger disabled">Hapus</button>
        </div>
    </div>
    <div class="row mt-3">
        <table class="table table-striped text-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Judul Dokumen</th>
                    <th scope="col">Tanggal Tanda Tangan</th>
                    <th scope="col">Dokumen Asli</th>
                    <th scope="col">Dokumen Tertanda Tangan</th>
                    <th scope="col">QRCode</th>
                    <th scope="col">Pilih</th>
                </tr>
            </thead>
            <tbody>
                <?php

                use Myth\Auth\Models\UserModel;

                $userModel = new UserModel();

                $i = 1 + (10 * ($currentPage - 1));
                foreach ($documents as $document) : ?>
                    <?php
                    $date = date_create($document['created_at']);
                    $date = date_format($date, 'd/m/Y h:i');
                    ?>


                    <tr>
                        <th scope="row"><?= $i ?></th>
                        <td><?= $document['document_title'] ?></td>
                        <td><?= $date ?></td>
                        <td><a target="_blank" href="<?= base_url() ?>/uploads/documents/original/<?= $document['document_filename'] ?>"><span class="badge badge-pill badge-primary">Download</span></a></td>
                        <td><a target="_blank" href="<?= base_url() ?>/uploads/documents/qrcode/<?= $document['document_filename'] ?>"><span class="badge badge-pill badge-primary">Download</span></a></td>
                        <td><a target="_blank" href="<?= base_url() ?>/uploads/qrcode/<?= $document['qrcode_hash'] . '.png' ?>"><span class="badge badge-pill badge-primary">Download</span></a></td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="<?= $document['id'] ?>">
                            </div>
                        </td>
                    </tr>
                    <?php $i++ ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?= count($documents) > 10 ? $pager->links('documents', 'document_pagination') : '' ?>
    </div>
</div>

<!-- Delete Document Modal -->
<div class="modal fade" id="deleteDocument" tabindex="-1" aria-labelledby="deleteDocumentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDocumentLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Anda yakin ingin menghapus dokumen yang anda pilih ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="<?= base_url() ?>/document/delete?id=" class="btn btn-primary" id="deleteButton">Ya</a>
            </div>
        </div>
    </div>
</div>

<script>
    const selectBox = document.querySelectorAll('.form-check-input');
    const modalButton = document.getElementById('modalButton');
    const deleteButton = document.getElementById('deleteButton');
    var ids = [];
    selectBox.forEach(function(e, i) {
        e.addEventListener('change', function() {
            if (this.checked) {
                ids.push(this.value);
                deleteButton.href = `${location.protocol}//${location.host}/document/delete?id=${ids.join(',')}`;
            }

            if (!this.checked) {
                const index = ids.indexOf(this.value);
                if (index > -1) ids.splice(index);
                deleteButton.href = `${location.host}/document/delete?id=${ids.join(',')}`;
            }

            if (ids.length == 0) {
                modalButton.disabled = true;
                modalButton.classList.add('disabled')
            } else if (ids.length > 0) {
                modalButton.disabled = false;
                modalButton.classList.remove('disabled')
            }
        })
    })

    document.getElementById('deleteButton').addEventListener('click', function(e) {
        window.location = e.target.href;
    })
</script>

<?= $this->endSection() ?>