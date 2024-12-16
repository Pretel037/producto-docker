<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/formulario.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="custom-title">Bienvenido, ¿qué desea hacer hoy?</h2>
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-4 mb-3 d-flex justify-content-center align-items-center">
                <div class="card payment-option" onclick="redirectToRoute('{{ route('login') }}')">
                    <img src="https://cdn-icons-png.flaticon.com/512/5087/5087579.png" alt="Plin Logo" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Login</h5>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function redirectToRoute(route) {
            window.location.href = route;
        }
    </script>
</body>
</html>
