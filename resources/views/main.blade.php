<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" src="{{asset('icons/biodigy_icon.png')}}"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    </head>
        
    <body>
    <div class="style">
        @yield('style')
    </div>
    <div id="unauthorized"> YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE </div>
    <div id="authorized">
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <a class="navbar-brand" href="/home">Activities</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/profile"> Profiles <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/skill">Skills</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/user">User</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <p id="userName" class="my-2 mr-4 text-warning"> UserName </p>
                </form>
                <form class="form-inline my-2 my-lg-0">
                    <button id="logout_btn" class="btn my-2 my-sm-0 text-white">Logout</button>
                </form>
            </div>
        </nav>
            @section('sidebar')
            @show

            <div class="container">
                @yield('content')
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="delete-modal">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Are you sure want to delete?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="submitDelete();">Yes</button>
                        <button type="button" class="btn btn-primary" onclick="cancelDelete();">No</button>
                    </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="alertModal" aria-hidden="true" id="alert-modal">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content  alert alert-primary">
                        <div class="modal-header modal-text"> This is modal content </div>
                    </div>
                </div>
            </div>
    </div>
    </body>
    <script type="text/javascript" src="{{ URL::asset('js/main.js') }}"></script> 

    <div class="script">
        @yield('script')
    </div>
</html>