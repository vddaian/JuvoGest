@extends('layouts.app')
@section('title', 'Información')
@section('head')
    <script src="{{ asset('js/global.js') }}"></script>
@endsection
@section('content')

    <div class="titleBlock d-flex justify-content-between align-items-center">
        <h2 class="mt-3 p-4">Información</h2>
        <a class="mt-3 p-4" style="color: white" onclick="charge()" href="{{ route('login.index') }}">Acceder</a>
    </div>

    <div class="d-flex align-items-center justify-content-center">

        <div class="p-3" style="width:90%; position-relative">
            <div class="col-12 row">
                <div class="col-lg-6 ">
                    <h3>¿Que es JuvoGest?</h3>
                    <hr class="del">
                    <p>JuvoGest es una aplicación que sirve para llevar a cabo todo el sistema básico de gestión para un
                        centro juvenil. Dentro de ella tenemos la posibilidad de gestionar los siguientes apartados:</p>
                    <ol>
                        <li>Socios.</li>
                        <li>Incidencias causadas por los mismos socios.</li>
                        <li>Salas.</li>
                        <li>Recursos.</li>
                        <li>Eventos.</li>
                    </ol>
                    <p>Aparte de todos los apartados que se pueden gestionar hay un apartado de estadisticas, donde se puede
                        visualizar un registro mensual de socios nuevos y de las incidencias ocurridas.</p>
                    <p>JuvoGest ira creciendo poco a poco gracias al esfuerzo del equipo y de los centros que trabajan con
                        ella, asi que unete al equipo!</p>
                </div>
                <div class="col-lg-6 ">
                    <h3>Comienza a gestionar tu centro!</h3>
                    <hr class="del">
                    <p>Para poder comenzar a gestionar y tener acceso a nuestra aplicación empieza mandando un correo a
                        <strong>info@juvogest.com</strong> pidiendo un presupuesto y con un metodo de contacto, luego de
                        ello nos pondremos en contacto contigo.
                    </p>
                    <p>Para el alta debes tener en cuenta la información que debes aportar:</p>
                    <ol>
                        <li>Nombre del centro.</li>
                        <li>Dirección completa.</li>
                        <li>Información de contacto.</li>
                        <li>Metodo de pago.</li>
                    </ol>
                </div>
                <div class="col-lg-6 ">
                    <h3>Información de privacidad</h3>
                    <hr class="del">
                    <p>Antes de darte de alta debes saber que los datos que proporcionas tanto como centro como de los
                        diferentes socios que se dan de alta en dicho centro se almacenan. <br><br>
                        Aparte del consentimiento del centro tambien se necesita el consentimiento del socio para poder
                        almacenar sus datos personales. Estos datos posteriormente por solicitud del mismo socio se pueden
                        eliminar permanentemente del sistema. <br><br> Hay que tener en cuenta que si el socio esta dado de alta en
                        otro centro y solicita el borrado de sus datos se eliminaran tambien en otros centros dado al
                        sistema de comunicación de socios entre centros. <br><br>
                        Para poder dar de baja tanto el centro como el socio de forma permanente se debe mandar un correo a 
                        <strong>info@juvogest.com</strong> pidiendo dicha baja.
                    </p>
                </div>
                <div class="col-lg-6 ">
                    <h3>Soporte</h3>
                    <hr class="del">
                    <p>Si tienes alguna duda sobre la app o algun problema que ha surgido con ella, no dudes en ponerte en
                        contacto con nosotros mediante nuestro correo de soporte: <strong>soporte@juvogest.com</strong></p>
                </div>
            </div>
        </div>
    </div>

@endsection
