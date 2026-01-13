<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Livewire Modal Example</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="p-10">

    @livewire('contact-modal')

    @livewireScripts
</body>
</html>
