<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link href="<?php echo e(asset('css/app-build.css')); ?>" rel="stylesheet">
</head>
<body class="<?php echo e(body_class()); ?>">
    <div id="app"></div>
    <?php echo $__env->make('index.dataTransfer.backendConfig', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
</body>
</html><?php /**PATH /var/www/resources/views/index/app.blade.php ENDPATH**/ ?>