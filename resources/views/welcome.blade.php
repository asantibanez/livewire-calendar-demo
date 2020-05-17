<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    @livewireStyles
</head>
<body>

<div class="container mx-auto">
    <livewire:appointments-calendar
        before-calendar-view="header"
    />
</div>

@livewireScripts
@livewireCalendarScripts
</body>
</html>
