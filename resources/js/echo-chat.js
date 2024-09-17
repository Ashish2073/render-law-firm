import Echo from 'laravel-echo';
import io from 'socket.io-client';

export function setupEcho(caseId) {
    // Set up Laravel Echo with Reverb
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname + ':6001', 
        client: io,
    });

    // Listen to the specific channel for this case
    window.Echo.channel('case-message-channel.' + caseId)
        .listen('SendMessage', (data) => {
            console.log('New message for case ' + caseId + ':', data.message);

            if (data.attachment) {
                console.log('Attachment file:', data.attachment);
                // Handle the attachment in your UI
            }
        });
}
