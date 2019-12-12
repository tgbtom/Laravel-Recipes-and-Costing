<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('style')
    <title>@yield('title')</title>
</head>
<body>

    <aside>
        <table class="spaciousLite">
            <tr><td><a href="/recipe">All Recipes</a></td></tr>
            <tr><td><a href="/ingredient">All Ingredients</a></td></tr>
            <tr><td><a href="/recipe/create">Create New Recipe</a></td></tr>
            <tr><td><a href="/ingredient/create">Create New Ingredient</a></td></tr>
        </table>
    </aside>

    <div class="container">
        @yield('content')

        <div class="container2">
            @yield('content2')
        </div>
    </div>

</body>
</html>