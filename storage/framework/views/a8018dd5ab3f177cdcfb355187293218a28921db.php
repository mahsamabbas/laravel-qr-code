<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" href="<?php echo e(asset('assets/images/favicon.png')); ?>" />

    <title><?php echo e(config('app.name', 'Qr Code')); ?></title>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <script src="https://kit.fontawesome.com/21f9eb4e12.js"></script>
    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
</head>
<body>
    
    <div id="app">
        <router-view/>
        
    </div>
</body>
<script type="text/javascript">
</script>
</html>

<?php /**PATH /var/www/html/laravel-qr-code/resources/views/welcome.blade.php ENDPATH**/ ?>