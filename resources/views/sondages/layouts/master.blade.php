<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="@Designpond | Cindy Leschaud">
    <title>Droit Formation | Sondage</title>
    <meta name="description" content="Administration">
    <meta name="_token" content="<?php echo csrf_token(); ?>">

    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('backend/css/styles.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('common/css/validation.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('common/css/sondage.css');?>">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="https://use.fontawesome.com/037c712a00.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <script src="<?php echo asset('common/js/messages_fr.js');?>"></script>
    <script src="<?php echo asset('common/js/validation.js');?>"></script>

</head>
<body>

    <!-- messages and errors -->
    @include('backend.partials.message')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                   <div class="panel-body">
                       <h1 class="auth-logo text-center">
                           <a class="text-inverse" href="{{ url('/') }}">
                               <img style="max-height: 100px;" src="{{ asset('emails/logos/pubdroit.png') }}" alt="{{ url('/pubdroit') }}">
                           </a>
                       </h1>
                       <!-- Contenu -->
                       @yield('content')
                       <!-- Fin contenu -->
                   </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
