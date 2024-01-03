
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--google-->
    <meta name="google-signin-client_id" content="702212359695-3off959dmivme1pi082u54rq2hkg4fbo.apps.googleusercontent.com">
    
    <title>App Salón</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="/build/css/app.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    

 
</head>
<body>

    <div class="contenedor-app">
        <div class="imagen">
            
        </div>

        <div class="app">
            <?php echo $contenido; ?>
        </div>
    </div>

    <?php 
        //donde este creada la variable de
        // script va imprimilar de lo contrario imprime nada
        echo $script ?? '';
    ?>
<script>
    function onSignIn(googleUser) {
        var id_token = googleUser.getAuthResponse().id_token;
        var profile = googleUser.getBasicProfile();
        console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
        console.log('Name: ' + profile.getName());
        console.log('Image URL: ' + profile.getImageUrl());
        console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

        console.log(id_token);
    }

    function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            console.log('User signed out.');
        });
    }
</script>
  
</body>
</html>


