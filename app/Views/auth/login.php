<?= $this->extend('auth/layout') ?>

<?= $this->section('auth') ?>
<div class="h-32 md:h-auto md:w-1/2">
    <img aria-hidden="true" class="object-cover w-full h-full dark:hidden" src="../assets/img/login-office.jpeg" alt="Office" />
    <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block" src="../assets/img/login-office-dark.jpeg" alt="Office" />
</div>
<div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
    <div class="w-full">



        <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
            Login
        </h1>

        <?php if (session('error') !== null) : ?>
            <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
        <?php elseif (session('errors') !== null) : ?>
            <div class="alert alert-danger" role="alert">
                <?php if (is_array(session('errors'))) : ?>
                    <?php foreach (session('errors') as $error) : ?>
                        <?= $error ?>
                        <br>
                    <?php endforeach ?>
                <?php else : ?>
                    <?= session('errors') ?>
                <?php endif ?>
            </div>
        <?php endif ?>

        <?php if (session('message') !== null) : ?>
            <div class="alert alert-success" role="alert"><?= session('message') ?></div>
        <?php endif ?>

        <form action="<?= url_to('login') ?>" method="post">
            <?= csrf_field() ?>
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Email</span>
                <input type="email" inputmode="email" name="email" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-900 focus:border-purple-400 focus:outline-none focus:ring focus:ring-purple-400 dark:text-gray-300   dark:focus:ring-gray-500 dark:focus:border-gray-500 rounded transition" placeholder="example@gmail.com" autocomplete="email" />
            </label>
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Password</span>
                <input type="password" autocomplete="current-password" name="password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-900 focus:border-purple-400 focus:outline-none focus:ring focus:ring-purple-400 dark:text-gray-300   dark:focus:ring-gray-500 dark:focus:border-gray-500 rounded transition" placeholder="***************" />
            </label>

            <button type="submit" class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Log in
            </button>
        </form>

        <hr class="my-8" />

        <p class="mt-4">
            <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="#">
                Forgot your password?
            </a>
        </p>
        <p class="mt-1">
            <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="<?= route_to('register') ?>">
                Create account
            </a>
        </p>
    </div>
</div>
<?= $this->endSection() ?>