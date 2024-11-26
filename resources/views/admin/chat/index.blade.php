@extends('layouts.backend.admin')
@push('css')
    <style>
        /* Chat-specific styles */
        .chat-container {
            display: flex;
            height: 70vh;
        }

        .sidebar {
            width: 25%;
            max-width: 300px;
            background-color: #f8f9fa;
            overflow-y: auto;
            border-right: 1px solid #ddd;
        }

        .chat-box {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            height: 100% !important;
        }

        .messages {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #f4f4f4;
        }

        .messages .text-start {
            align-self: flex-start;
            text-align: left;
            background-color: #e1f5fe;
            color: #0d47a1;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 8px;
        }

        .messages .text-end {
            align-self: flex-end;
            text-align: right;
            background-color: #ffe0b2;
            color: #e65100;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 8px;
        }

        .message-input {
            border-top: 1px solid #ddd;
            padding: 10px;
            display: flex;
            align-items: center;
        }

        .message-input textarea {
            width: 100%;
            resize: none;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .send-btn {
            margin-left: 10px;
            padding: 10px 20px;
            border-radius: 10px;
            color: white;
            background-color: #007bff;
            border: none;
        }

        .list-group-item.active {
            background-color: #007bff;
            color: white;
        }
    </style>
@endpush
@section('content')
    @include('layouts.backend.alert')
    <div class="container-fluid chat-container mb-30">
        <!-- Sidebar for customer list -->
        <div class="sidebar p-3">
            <h5 class="text-center mb-3">Pelanggan</h5>
            <ul class="list-group">
                @foreach ($pelanggan as $item)
                    <li class="list-group-item customer" data-customer-id="{{ $item->id }}">{{ $item->name }}
                        <span class="" id="count_notif" data-id="{{ $item->id }}"></span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Chat box for displaying messages -->
        <div class="chat-box">
            <div class="messages" id="messages">
                <!-- Messages will be dynamically loaded here -->
            </div>
            <div class="message-input">
                <textarea id="adminMessage" rows="1" placeholder="Type a message..."></textarea>
                <button class="send-btn" id="sendButton">Send</button>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        const authUserId = Number({{ Auth::id() }});
        let selectedCustomerId = null;
        let messagePollingInterval;

        $('.customer').click(function() {
            $('.customer').removeClass('active');
            $(this).addClass('active');

            selectedCustomerId = $(this).data('customer-id');
            loadMessages(selectedCustomerId);

            startMessagePolling(selectedCustomerId);
        });

        function loadMessages(customerId) {
            $.get(`/messages/${customerId}`, function(data) {
                let messagesContainer = $('#messages');
                messagesContainer.html('');

                data.forEach(function(message) {
                    const senderName = Number(message.sender_id) === authUserId ?
                        '<span class="sender">Kamu</span>' :
                        `<span class="customer">${message.sender.name}</span>`;

                    const messageClass = Number(message.sender_id) === authUserId ? 'text-start' :
                        'text-end';

                    const messageHtml = `
                <div class="${messageClass}">
                    <strong>${senderName}<br></strong>
                    <div class="message-content">${message.message}</div>
                </div>`;

                    messagesContainer.append(messageHtml);
                });

                messagesContainer.scrollTop(messagesContainer[0].scrollHeight);
            }).fail(function() {
                console.error('Failed to load messages.');
            });
        }

        function startMessagePolling(customerId) {
            clearInterval(messagePollingInterval);

            messagePollingInterval = setInterval(function() {
                loadMessages(customerId);
            }, 1000);
        }


        // Sending a new message
        $('#sendButton').click(function() {
            const message = $('#adminMessage').val();
            if (message.trim() && selectedCustomerId) {
                $.post('/send-message', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    receiver_id: selectedCustomerId,
                    message: message
                }, function() {
                    $('#adminMessage').val('');
                    loadMessages(selectedCustomerId);
                }).fail(function() {
                    console.error('Failed to send message.');
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            function loadNotificationCount() {
                let receiverId = $('#count_notif').data('id');

                $.ajax({
                    url: `/chat-count/${receiverId}`,
                    method: 'GET',
                    success: function(response) {
                        let count = response.count || response;
                        if (count > 0) {
                            $('#count_notif').html(`<span class="badge badge-danger">${count}</span>`);
                        } else {
                            $('#count_notif').html('');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading notification count:', error);
                    }
                });
            }

            loadNotificationCount();
            setInterval(loadNotificationCount, 1000);
        });
    </script>
@endpush
