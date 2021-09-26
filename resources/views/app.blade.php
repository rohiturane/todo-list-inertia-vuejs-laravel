<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link href="{{asset('/css/app.css')}}" rel="stylesheet"/>
    <script src="{{asset('/js/app.js') }}" defer></script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12 m-3 pb-3">
            <h1 class="app-title">Todo List</h1>
        </div>
    </div>
</div>
<hr>
<div class="container mt-2">
    <div class="row">
        @inertia
    </div>
</div>

</body>
</html>