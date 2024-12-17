 


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: linear-gradient(to right, #4facfe, #00f2fe);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            animation: gradientAnimation 10s ease infinite;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #555;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #4facfe;
            outline: none;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-primary {
            background-color: #4facfe;
            border-color: #4facfe;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0396ff;
            border-color: #0396ff;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #495057;
            border-color: #495057;
            transform: translateY(-2px);
        }

        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            animation: shake 0.5s;
        }

        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
            100% { transform: translateX(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Iniciar Sesión</h2>

        @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
        @endif

        <!-- Formulario de Autenticación -->
        <form id="loginForm" method="POST" action="{{ url('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-primary" id="btn_webcam">Validar con Webcam</button>
            </div>
        </form>

        <!-- Webcam -->
        <div class="text-center mt-4">
            <video id="webcam" width="320" height="240"></video>
            <canvas id="canvas" class="d-none"></canvas>
            <p id="webcamStatus" class="text-muted"></p>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalMensaje" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Mensaje</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    Validación fallida.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const webcamElement = document.getElementById('webcam');
            const canvasElement = document.getElementById('canvas');
            const webcam = new Webcam(webcamElement, 'user', canvasElement);
            let isWebcamValidated = false;

            // Iniciar la webcam
            webcam.start().then(() => {
                $("#webcamStatus").text("Webcam lista.");
            }).catch(err => {
                console.error(err);
                $("#webcamStatus").text("No se pudo iniciar la webcam.");
            });

            // Botón de validación con webcam
            $("#btn_webcam").click(async function() {
                const picture = await webcam.snap();
                $.post("https://u0tug27t8f.execute-api.us-east-2.amazonaws.com/Test2/",
                    JSON.stringify({ imgvalidacion: picture }),
                    function(respuesta) {
                        if (respuesta.body.codigo == 0) {
                            alert("Validación exitosa. Usted es: " + respuesta.body.similutud);
                            isWebcamValidated = true;
                            $("#loginForm").submit();
                        } else {
                            $("#modalBody").text("La validación falló. Intente nuevamente.");
                            $("#modalMensaje").modal('show');
                        }
                    }
                );
            });

            // Previene envío sin webcam validada
            $("#loginForm").submit(function(event) {
                if (!isWebcamValidated) {
                    event.preventDefault();
                    alert("Primero debe validar su identidad con la webcam.");
                }
            });
        });
    </script>
</body>
</html>
