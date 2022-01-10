<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Profile</h1>
    <div class="container">
        <form method="post" action="<?= route_to('profile') ?>" enctype="multipart/form-data">

            <div class="mb-3 w-25 h-25 mx-auto position-relative">
                <img class="rounded-circle w-100 h-100" id="imagePreview" src="<?= base_url() ?>/uploads/users/<?= user()->image ?? 'default.jpg' ?>" alt="user-image">
                <div id="overlay" class="overlay rounded-circle">
                    <p class="text-center">Ubah Foto Profil</p>
                </div>
                <input type="file" name="image" accept="image/*" id="selectImage" class="d-none">
            </div>
            <div class="mx-auto w-25">
                <small class="text-center">Pastikan foto memiliki rasio 1:1</small>
            </div>

            <div class="form-group">
                <label for="username">ID Number</label>
                <input type="text" name="id_number" class="form-control <?= $validator->getError('id_number') ? 'is-invalid' : '' ?>" value="<?= user()->id_number ?>" <?= user()->id_number ? 'readonly' : '' ?>>
                <small>Untuk mahasiswa isi dengan NIM, dosen isi dengan NID, untuk Staff Sekretariat dengan NIP</small>
                <div class="invalid-feedback">
                    <?= $validator->getError('id_number') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="username">Nama Lengkap</label>
                <input type="text" name="name" class="form-control <?= $validator->getError('name') ? 'is-invalid' : '' ?>" value="<?= user()->name ?>" <?= user()->name ? 'readonly' : '' ?>>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control <?= $validator->getError('username') ? 'is-invalid' : '' ?>" value="<?= user()->username ?>" readonly>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control <?= $validator->getError('email') ? 'is-invalid' : '' ?>" value="<?= user()->email ?>" readonly>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Nomor Telepon</label>
                <input type="tel" name="phone" class="form-control <?= $validator->getError('phone') ? 'is-invalid' : '' ?>" value="<?= user()->phone ?>" <?= user()->phone ? 'readonly' : '' ?>>
            </div>


            <div class="form-group">
                <label for="">Role</label>
                <div class="input-group mb-3">
                    <select class="custom-select <?= $validator->getError('role') ? 'is-invalid' : '' ?>" id="inputGroupSelect01" name="role" <?= in_groups([1, 2, 3]) ? 'disabled=true' : '' ?>>
                        <option <?= !in_groups([1, 2, 3]) ? 'selected' : '' ?>>Choose...</option>
                        <?php foreach ($groups as $group) : ?>
                            <option value="<?= $group->id ?>" <?= in_groups($group->id) ? 'selected' : '' ?>><?= $group->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <?php if (is_null(user()->signature) || empty(user()->signature)) : ?>
                <div class="form-group">
                    <label for="">File Tanda Tangan</label>
                    <div class="custom-file">
                        <input type="file" name="signature" id="signature" accept="image/*" class="custom-file-input <?= $validator->getError('signature') ? 'is-invalid' : '' ?>">
                        <label class="custom-file-label" id="signatureLabel">Choose file...</label>
                        <div class="invalid-feedback">
                            <?= $validator->getError('signer_file') ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <img src="<?= base_url() ?>/uploads/signature/<?= user()->signature ?>" alt="Signature Image" width="200" class="img-thumbnail" id="signaturePreview">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('overlay').addEventListener('click', function(e) {
        document.getElementById('selectImage').click()
    })

    document.getElementById('selectImage').onchange = function(e) {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(e.target.files[0]);

        fileReader.onload = (e) => {
            document.getElementById('imagePreview').src = e.target.result;
        }
    }

    document.getElementById('signature').onchange = function(e) {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(e.target.files[0]);
        document.getElementById('signatureLabel').textContent = e.target.files[0].name;

        fileReader.onload = (e) => {
            document.getElementById('signaturePreview').src = e.target.result;


        }
    }
</script>
<?= $this->endSection() ?>