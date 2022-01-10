<?php

use Myth\Auth\Authorization\GroupModel;

$groupModel = new GroupModel();
?>

<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Profil Saya</h1>
    <div class="card mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="<?= base_url() ?>/uploads/users/<?= user()->image ?>" height="200" class="img-thumbnail rounded-circle" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= user()->name ?></h5>
                    <p class="card-text"><?= user()->id_number ?></p>
                    <p class="card-text"><small class="text-muted"><?= $groupModel->getGroupsForUser(user_id())[0]['name'] ?? 'Profil masih kosong' ?></small></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>