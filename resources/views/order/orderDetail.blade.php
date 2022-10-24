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
            <h2>Detalle de la orden</h2>
        </div>
        
        <div class="col-12">
            <div class="col-6 mx-auto" id="orderDetail">
                <div class="row">

                    <h5 class="mb-3">Orden</h5>
                    <div class="col-sm-12 d-flex justify-content-between">
                        <label for="documentType" class="form-label">Estatus</label>
                        <span>{{ $order->status }}</span>
                    </div>

                    <div class="col-sm-12 d-flex justify-content-between">
                        <label for="documentType" class="form-label">Identificador</label>
                        <span>{{ $order->identifier_code }}</span>
                    </div>

                    <div class="col-sm-12 d-flex justify-content-between">
                        <label for="productName" class="form-label">Producto</label>
                        <span> {{ $order->productName }} </span>
                    </div>
                    
                    <div class="col-sm-12 d-flex justify-content-between">
                        <label for="documentNumber" class="form-label">Total</label>
                        <span> US$ {{ number_format($order->total, 2) }} </span>
                    </div>

                    @if ( !is_null($order->payment_session) && $order->payment_status != 'PENDING' )
                        <hr class="my-4">

                        <h5 class="mb-3">Informión de pago</h5>

                        <div class="col-sm-12 d-flex justify-content-between">
                            <label for="paymentStatus" class="form-label col-6">Estatus</label>
                            <span id="paymentStatus">{{ $order->payment_status }}</span>
                        </div>
                        
                        <div class="col-sm-12 d-flex justify-content-between">
                            <label for="paymentStatus" class="form-label col-6">Fecha y hora</label>
                            <span id="paymentStatus">{{ $order->payment_date }}</span>
                        </div>
                    @endif
                    

                    <hr class="my-4">

                    <h5 class="mb-3">Información del cliente</h5>

                    <div class="col-sm-12 d-flex justify-content-between">
                        <label for="fullname" class="form-label col-6">Nombre Completo</label>
                        <span>{{ $order->customer_name }}</span>
                    </div>
                    
                    </div>
                    <div class="col-sm-12 d-flex justify-content-between">
                        <label for="email" class="form-label">Correo Electronico</label>
                        <span>{{ $order->customer_email }}</span>
                    </div>

                    <div class="col-sm-12 d-flex justify-content-between">
                        <label for="phoneNumber" class="form-label">Número telefonico</label>
                        <span>{{ $order->customer_mobile }}</span>
                    </div>

                    <div class="col-sm-12 d-flex justify-content-between">
                        <label for="documentType" class="form-label">Tipo de documento</label>
                        <span>{{ $order->customer_document_type }}</span>
                    </div>

                    <div class="col-sm-12 d-flex justify-content-between">
                        <label for="documentNumber" class="form-label">Número de documento</label>
                        <span>{{ $order->customer_document_number }}</span>
                    </div>
                    
                </div>

                <div class="row g-3 col-6 mx-auto mt-4">
                    @if ( $order->status != 'Pagado' )
                        <button
                            class="w-100 btn btn-primary btn-lg"
                            value="{{ $order->id }}"
                            onclick="createPaymentAttemp(this)"
                            type="submit"
                        >
                            @if ( is_null($order->payment_session) )
                                Pagar
                            @else
                                Reintentar pago
                            @endif

                        </button>
                    @endif

                    @if ( !is_null($order->payment_session)  )
                        <button
                            class="w-100 btn btn-primary btn-lg"
                            value="{{ $order->id }}"
                            onclick="finalizePayment(this)"
                            type="submit"
                        >
                            Finalizar
                        </button>
                    @endif
                </div>
            </div>
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

    <script type="text/javascript">
        
        function createPaymentAttemp(orderid)
        {
            orderId = orderid.value
            $.ajax({
                type: 'GET',
                url: "{{ url('order/payment-attemp/') }}"+'/'+orderId,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    const order = data.result
                    if (order.payment_url) {
                        url = order.payment_url;
                        window.location.href = url;
                    } else {
                        alert('Hubo un error con el pago, intentelo nuevamente');
                        location.reload();
                    }
                },
                error: function (data) {
                    alert('Ha ocurrido un error');
                },
            });
        }
        
        function finalizePayment(orderid)
        {
            window.location.href = "{{ url('/') }}";
        }
     
    </script>
  </body>
</html>
