<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIP Posyandu</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo-cimahi.png') }}">
    <script>
        window.CKEDITOR_BASEPATH = '/ckeditor/';
    </script>
    <script src="/ckeditor/ckeditor.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.ts'])
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>