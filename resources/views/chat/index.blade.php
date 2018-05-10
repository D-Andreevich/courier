<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta class="csrf-token" id="_token" name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Courier') }}</title>

</head>
<body>

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
                    @foreach($messages as $message)
                        <li>
                            <b>{{ $message->author }}</b>
                            <p>{{ $message->message }}</p>
                        </li>
                    @endforeach
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
                    {{ csrf_field() }}
                    <label for="author">author:<input type="text" name="author" id="author"></label>
                    <br/>
                    <label for="messages">messages:<input type="text" name="message" id="messages"></label>
                    <br/>
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
            $('<li/>').html('<b>' + data.author + '</b>' + '<p>' + data.message + '</p>')
        );
    }
    $('form').on('submit', function () {
        var text = $('#messages').val(), author = $('#author').val(),
            msg = {message: text, author: author};
//        socket.send(msg);

        $.ajax({
            type: 'POST',
            url: '/chat/message',
            headers: {
                'X-CSRF-Token': $('#_token').attr('content')
            },
            data: msg,
            success: function (data) {
                console.log(data);
                if (data) {
                    //
                } else {
                    //
                }
            }
        });
//        appendMessage(msg);
        $('#messages').val('');
        $('#author').val('');
        return false;
    });

        socket.on('chat:message', function (data) {
            console.log(data);
            appendMessage(data);
        })
</script>

</body>
</html>
