<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Informacion Personal</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="{{url('formValidatios/form-validation.css')}}" rel="stylesheet">
  </head>
  <body class="bg-light">
    
    <div class="container">
    <main>
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="https://static.placetopay.com/placetopay-logo.svg" alt="" width="200" height="100%">
            <h2>Informacion personal</h2>
        </div>

        <div class="col-12">
            <form class="needs-validation col-6 mx-auto" id="personalInformationForm" action="">
                <div class="row g-3">
                    <div class="col-sm-12">
                        <label for="fullname" class="form-label">Nombre completo</label>
                        <input
                            name="customer_name"
                            type="text"
                            class="form-control"
                            id="fullname"
                            placeholder="Nombre completo"
                            value=""
                            required
                        >
                        <div class="invalid-feedback">
                            El nombre completo es requerido.
                        </div>
                    </div>
                    
                    </div>
                    <div class="col-12">
                        <label for="email" class="form-label">Correo Electronico</label>
                        <input
                            name="customer_email"
                            type="email"
                            class="form-control" id="email" placeholder="tu@ejemplo.com" required>
                        <div class="invalid-feedback">
                            Por favor, introduzca una dirección de correo valida.
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label for="phoneNumber" class="form-label">Número telefonico</label>
                        <input
                            name="customer_mobile"
                            type="text"
                            class="form-control"
                            id="phoneNumber"
                            placeholder="+57 313XXXXXXX"
                            value=""
                            required
                        >
                        <div class="invalid-feedback">
                            El número de telefono es requerido.
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label for="documentType" class="form-label">Tipo de documento</label>
                        <select name="customer_document_type" class="form-select" id="documentType" required>
                            <option value="">Seleccione...</option>
                            <option value="C.C">Cédula de ciudadania</option>
                            <option value="C.E">Cédula de extranjeria</option>
                            <option value="P.P">Pasaporte</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, sleccione un tipo de documento correcto
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label for="documentNumber" class="form-label">Número de documento</label>
                        <input
                            name="customer_document_number"
                            type="text"
                            class="form-control"
                            id="documentNumber"
                            placeholder="1234567890"
                            value=""
                            required
                        >
                        <div class="invalid-feedback">
                            El número de documento es requerido.
                        </div>
                    </div>
                </div>

                <div class="row g-3 col-6 mx-auto mt-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="termAndConditions" required>
                        <label class="form-check-label" for="termAndConditions">Acepto los terminos y condiciones</label>
                    </div>
                    <div class="" hidden>
                        <input type="number" name="product_id" value="{{ $product->id }}">
                    </div>
                    <div class="" hidden>
                        <input type="number" name="total" value="{{ $product->price }}">
                    </div>

                    <button class="w-100 btn btn-primary btn-lg" type="submit">Continuar</button>
                </div>
            </form>
        </div>
    </main>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017–2021 Company Name</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="/">Inicio</a></li>
        </ul>
    </footer>
    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous">
    </script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>


    <script src="{{url('formValidatios/form-validation.js')}}"></script>

    <script type="text/javascript">
        var frm = $('#personalInformationForm');
        

        frm.submit(function (e) {

            var data = frm.serialize();
            data['eee'] ='aa';

            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: "{{ route('order.create') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: data,
                success: function (data) {
                    let orderId = data.result.id;
                    url = "{{ url('orden/detalle') }}"+"/"+orderId;
                    window.location.href = url;
                },
                error: function (data) {
                    console.log('An error occurred.');
                },
            });
        });
    </script>
  </body>
</html>
