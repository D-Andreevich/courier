@extends('layouts.app')

@section('content')
    <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.0/socket.io.js"></script>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="">
                    <ul class="chat">

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Send message</div>
                    <form>
                        <input type="text" name="message" id="messages">
                        <input type="submit" value="send">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var socket = io(':6001');

        function appendMessage(data) {
            $('.chat').append(
                $('<li/>').text(data.message)
            );
        }
        $('form').on('submit', function () {
            var text = $('#messages').val(),
                msg = {message: text};
            socket.send(msg);
            appendMessage(msg);
            $('#messages').val('');
            return false;
        });

        socket.on('message', function (data) {
            appendMessage(data);
        })
    </script>


@endsection
