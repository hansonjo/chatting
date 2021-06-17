@extends('layout')

@section('content')
<div class="container">
    <div class="background-container">
        <div class="main-container">
            <header>
                <h1 class="title">Chatting</h1>
                <input class="form-control" type="text" name="username" id="username" placeholder="Please enter a Username"/>
            </header>

            <div id="messages"></div>

            <form id="message_form">
                <input type="text" name="message" id="message_input" placeholder="Type your message here" class="form-control"/>
                <button type="submit" id="message_send" class="btn btn-dark">Send</button>
            </form>
        </div>
    </div>
</div>
<div id="duplicate"></div>
@endsection


@push('script')
<script>
const messages_el = document.getElementById("messages");
const username_input = document.getElementById("username");
const message_input = document.getElementById("message_input");
const message_form = document.getElementById("message_form");

message_form.addEventListener('submit', function (e) {
    e.preventDefault();

    if(username_input.value == '') {
        alert('Please enter a username');
        return;
    }
    if(message_input.value == ''){
        alert('Please enter a message');
        return;
    }

    $.ajax({
        type: 'POST',
        method: "POST",
        url: "/send-message",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            username: username_input.value,
            message: message_input.value,
        },
        success: function(e){
            console.log(e);
        }
    });
});

window.Echo.channel('chat')
    .listen('.message',(e) => {
        console.log(e);
        messages_el.innerHTML += "<div class='message'>" + e.username + ": " + e.message + "</div>"
    })
</script>
@endpush