<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Profil Saya</h1>

    <form action="<?= route_to('change-password') ?>" method="post">
        <div class="form-group">
            <label for="oldPassword">Kata Sandi Lama</label>
            <input type="password" name="old_password" class="form-control" id="oldPassword">
        </div>
        <div class="form-group">
            <label for="newPassword">Kata Sandi Baru</label>
            <input type="password" name="new_password" class="form-control" id="newPassword">
        </div>
        <div class="form-group">
            <label for="confirmPassword">Konfirmasi Kata Sandi</label>
            <input type="password" name="confirm_password" class="form-control" id="confirmPassword">
        </div>

        <button type="submit" class="btn btn-primary">Ubah Kata Sandi</button>
    </form>
</div>
<?= $this->endSection() ?>