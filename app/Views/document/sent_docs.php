<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dokumen Kiriman</h1>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#tome" role="tab" aria-controls="home" aria-selected="true">Untuk Saya</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#fromme" role="tab" aria-controls="profile" aria-selected="false">Untuk Pihak Lain</a>
        </li>

    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="tome" role="tabpanel" aria-labelledby="home-tab">
            <div class="row mt-2">
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
                <table class="table table-striped text-dark">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Judul Dokumen</th>
                            <th scope="col">Nama Pengirim</th>
                            <th scope="col">Tanggal Kiriman</th>
                            <th scope="col">Tanda Tangan</th>
                            <th scope="col">Dokumen Original</th>
                            <th scope="col">Tanggal Tanda Tangan</th>
                            <th scope="col">Dokumen Tertanda Tangan</th>
                            <th scope="col">QRCode</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        use Myth\Auth\Models\UserModel;

                        $userModel = new UserModel();

                        $i = 1;

                        foreach ($tomes as $tome) : ?>
                            <tr>
                                <th scope="row"><?= $i ?></th>
                                <td><?= $tome['document_title'] ?></td>
                                <td><?= $userModel->where('id', $tome['from_id'])->first()->name ?></td>
                                <td><?= $tome['created_at'] ?></td>
                                <td>
                                    <?php if ($tome['signed'] == 0) : ?>
                                        <a class="btn btn-warning btn-sm text-dark" href="<?= base_url() ?>/editor?id=<?= $tome['id'] ?>&name=<?= $tome['document_filename'] ?>&redirect=true">Tanda Tangani</a>

                                    <?php elseif ($tome['signed'] == 1) : ?>
                                        <span class="badge badge-success">Sudah Tertanda Tangan</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($tome['signed'] != 2) : ?>
                                        <a target="_blank" href="<?= base_url() ?>/uploads/documents/original/<?= $tome['document_filename'] ?>"><span class="badge badge-pill badge-primary">Download</span></a>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($tome['signed'] == 0) : ?>
                                        <span class="badge badge-warning">Belum ditanda tangani</span>
                                    <?php elseif ($tome['signed'] == 1) : ?>
                                        <?= $tome['updated_at'] ?>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Ditolak</span>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <?php if ($tome['signed'] == 0) : ?>
                                        <span class="badge badge-warning">Belum ditanda tangani</span>
                                    <?php elseif ($tome['signed'] == 1) : ?>
                                        <a target="_blank" href="<?= base_url() ?>/uploads/documents/qrcode/<?= $tome['document_filename'] ?>"><span class="badge badge-pill badge-primary">Download</span></a>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Ditolak</span>
                                    <?php endif ?>
                                <td>
                                    <?php if ($tome['signed'] == 0) : ?>
                                        <span class="badge badge-warning">Belum ditanda tangani</span>
                                    <?php elseif ($tome['signed'] == 1) : ?>
                                        <a target="_blank" href="<?= base_url() ?>/uploads/qrcode/<?= $tome['qrcode_hash'] ?>.png"><span class="badge badge-pill badge-primary">Download</span></a>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Ditolak</span>
                                    <?php endif ?>

                                <td>
                                    <?php if ($tome['signed'] == 0) : ?>
                                        <a href="<?= base_url() ?>/reject?id=<?= $tome['id'] ?> " class="badge badge-danger">Tolak</a>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <?php $i++ ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?= count($tomes) > 10 ? $toPager->links('tomes', 'document_pagination') : '' ?>
            </div>
        </div>

        <div class="tab-pane fade" id="fromme" role="tabpanel" aria-labelledby="profile-tab">

            <div class="row mt-2">
                <div class="col">
                    <form action="<?= base_url() ?>/sent-docs" method="post">
                        <div class="input-group mb-3">
                            <input type="text" name="keyword" class="form-control" style="height: 38px;" placeholder="Cari dokumen" aria-label="Cari dokumen" aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col">
                    <form action="<?= base_url() ?>/sent-docs" method="post">
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
            <div class="row mb-3">
                <div class="col text-right">
                    <button id="modalButton" data-toggle="modal" data-target="#deleteDocument" class="btn btn-danger disabled">Hapus</button>
                </div>
            </div>

            <div class="row">
                <table class="table table-striped text-dark">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Judul Dokumen</th>
                            <th scope="col">Nama Pengirim</th>
                            <th scope="col">Tanggal Kiriman</th>
                            <th scope="col">Tanda Tangan</th>
                            <th scope="col">Dokumen Original</th>
                            <th scope="col">Tanggal Tanda Tangan</th>
                            <th scope="col">Dokumen Tertanda Tangan</th>
                            <th scope="col">QRCode</th>
                            <th scope="col">Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $userModel = new UserModel();

                        $i = 1;

                        foreach ($frommes as $fromme) : ?>
                            <tr>
                                <th scope="row"><?= $i ?></th>
                                <td><?= $fromme['document_title'] ?></td>
                                <td><?= $userModel->where('id', $fromme['to_id'])->first()->name ?></td>
                                <td><?= $fromme['created_at'] ?></td>
                                <td>
                                    <?php if ($fromme['signed'] == 0) : ?>
                                        <a class="btn btn-warning btn-sm text-dark" href="<?= base_url() ?>/editor?id=<?= $fromme['id'] ?>&name=<?= $fromme['document_filename'] ?>">Tanda Tangani</a>

                                    <?php elseif ($fromme['signed'] == 1) : ?>
                                        <span class="badge badge-success">Sudah Tertanda Tangan</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($fromme['signed'] != 2) : ?>
                                        <a target="_blank" href="<?= base_url() ?>/uploads/documents/original/<?= $fromme['document_filename'] ?>"><span class="badge badge-pill badge-primary">Download</span></a>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($fromme['signed'] == 0) : ?>
                                        <span class="badge badge-warning">Belum ditanda tangani</span>
                                    <?php elseif ($fromme['signed'] == 1) : ?>
                                        <?= $fromme['updated_at'] ?>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Ditolak</span>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <?php if ($fromme['signed'] == 0) : ?>
                                        <span class="badge badge-warning">Belum ditanda tangani</span>
                                    <?php elseif ($fromme['signed'] == 1) : ?>
                                        <a target="_blank" href="<?= base_url() ?>/uploads/documents/qrcode/<?= $fromme['document_filename'] ?>"><span class="badge badge-pill badge-primary">Download</span></a>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Ditolak</span>
                                    <?php endif ?>
                                <td>
                                    <?php if ($fromme['signed'] == 0) : ?>
                                        <span class="badge badge-warning">Belum ditanda tangani</span>
                                    <?php elseif ($fromme['signed'] == 1) : ?>
                                        <a target="_blank" href="<?= base_url() ?>/uploads/qrcode/<?= $fromme['qrcode_hash'] ?>.png"><span class="badge badge-pill badge-primary">Download</span></a>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Ditolak</span>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="<?= $fromme['id'] ?>">
                                    </div>
                                </td>
                            </tr>
                            <?php $i++ ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?= count($frommes) > 10 ? $fromPager->links('frommes', 'document_pagination') : '' ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>