<!DOCTYPE html>
<html :class="{ 'dark': dark }" x-data="data" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Windmill Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />

    <script src="<?= base_url('assets/js/main.js') ?>" defer></script>


</head>

<body>
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
        <!-- Desktop sidebar -->

        <?= $this->include('components/sidebar') ?>
        <div class="flex flex-col flex-1 w-full">
            <?= $this->include('components/navbar') ?>


            <?= $this->renderSection('main') ?>
        </div>
    </div>


    <?= $this->renderSection('pageScripts') ?>
</body>

</html>