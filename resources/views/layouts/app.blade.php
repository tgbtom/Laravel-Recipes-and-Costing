<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Bootstrap CDN --}}
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
    @yield('style')
    <title>@yield('title')</title>
</head>
<body>

    <div class="container">
        <div class="flex-row justify-content-center mt-3 mb-4">
            <div class="row">      
                <div class="col-md-6 col-lg-3"><a class="btn btn-warning btn-sm mb-2" href="/recipe">All Recipes</a></div>
                <div class="col-md-6 col-lg-3"><a class="btn btn-warning btn-sm mb-2" href="/ingredient">All Ingredients</a></div>
                <div class="col-md-6 col-lg-3"><a class="btn btn-warning btn-sm mb-2" href="/recipe/create">Create New Recipe</a></div>
                <div class="col-md-6 col-lg-3"><a class="btn btn-warning btn-sm mb-2" href="/ingredient/create">Create New Ingredient</a></div>
            </div>  
            <div class="col">
                @yield('content')
            </div>
    
            <div class="container2">
                @yield('content2')
            </div>
        </div>
    </div>

</body>
</html>