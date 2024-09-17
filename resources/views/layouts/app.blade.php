<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title', env('APP_NAME'))
    </title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/x-icon">
    @vite('resources/js/app.js')


    <link rel="stylesheet" type="text/css" href="{{ asset('css/toaster.min.css') }}">



    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/demo.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fonts.css') }}">




    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/kaiadmin.css.map') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('chat/css/appchat.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins.min.css') }}">



    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/boostrap.min.css') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/boostrap5.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/button.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/toaster.min.css') }}">

    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">








    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>


    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/toaster.min.js') }}"></script>

    <script src="{{ asset('assets/js/demo.js') }}"></script>

    <script src="{{ asset('assets/js/kaiadmin.js') }}"></script>

    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    <script src="{{ asset('ckeditor5/ckeditor.js') }}"></script>



    <script src="{{ asset('assets/js/setting-demo2.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>


    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>


    <script src="{{ asset('js/datatables/datatables2.0.5.js') }}"></script>
    <script src="{{ asset('js/datatables/boostrap5.js') }}"></script>
    <script src="{{ asset('js/datatables/customTablePdf.js') }}" defer></script>


    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<body>


    <div class="wrapper">
      
        @include('layouts.sidebar')

     

        <div class="main-panel">


            <div class="main-header">

                @include('layouts.logoheader')

                @include('layouts.navbar')
            </div>
            <div class="container">

                <div class="page-inner">

                    @yield('content')

                </div>







                @include('layouts.footer')

            </div>

        </div>

        @include('layouts.customlayout')


    </div>


    <script src="{{ asset('assets/js/setting-demo.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script src="{{ asset('js/datatables/buttons.js') }}"></script>

    <script src="{{ asset('js/datatables/buttons.datatable.js') }}"></script>

    <script src="{{ asset('js/datatables/zip.js') }}"></script>

    <script src="{{ asset('js/datatables/pdfmake.js') }}"></script>

    <script src="{{ asset('js/datatables/pdfmake_vfs.font.js') }}"></script>

    <script src="{{ asset('js/datatables/html5.js') }}"></script>

    <script src="{{ asset('js/datatables/print.min.js') }}"></script>




    <script defer src="{{ asset('js/owl.carousel.min.js') }}"></script>


    @if (session()->has('permissionerror'))
        <script>
            toastr.error("{{ session('permissionerror') }}");
        </script>
    @endif


    @if (auth('lawyer')->check())
        @php $authId = auth('lawyer')->id(); @endphp
        @php $authGuard = 'lawyer'; @endphp
    @elseif(auth('web')->check())
        @php $authId = auth('web')->id(); @endphp
        @php $authGuard = 'user'; @endphp
    @elseif(auth('customer')->check())
        @php $authId = auth('customer')->id(); @endphp
        @php $authGuard = 'customer'; @endphp
    @else
        @php
            $authId = null;
            $authGuard = null;
        @endphp
    @endif

    @if ($authId && $authGuard)
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                console.log("Echo script running");

                Echo.channel('case-message-channel')
                    .listen('SendMessage', (data) => {
                        console.log(data);


                        let html = `<tr><td><div class="chat chat-left">
                          <div class="chat-avatar">
                            <div class="avatar bg-light-primary">
                                  <div class="avatar-content">A</div>
                                        </div>
                                           </div>
                                         <div class="chat-body">
                                          <div class="chat-content">
                                                <p>
                                           <span class="d-block " style="font-size: 11px;">
                                                 ${data.messenger_name} ( ${data.role} )
                                               </span>
                                                    ${data.message}
                                                    <span class=" pt-50 ml-1" style="font-size: 11px;">
                                                        ${data.created_at}
                        
                                                        </span>
               
                                                        </p>
                
                                                     </div>
                                                   </div>
                                               </div>
                                         </td>
                                         </tr>`;

                        if (data.attachment) {
                            console.log('Attachment file:', data.attachment);
                        }

                        let auth_id = "{{ $authId }}";
                        let auth_guard = "{{ $authGuard }}";



                        if (((data.messenger_id != auth_id) && (data.messenger_guard == auth_guard)) ||
                            ((data.messenger_id != auth_id) && (data.messenger_guard != auth_guard)) ||
                            ((data.messenger_id == auth_id) && (data.messenger_guard != auth_guard))) {
                            toastr.success(html);
                        }
                    });
            });
        </script>
    @else
        <script>
            console.log('User not logged in or guard not recognized.');
        </script>
    @endif






    <script>
        function passwordShowHide(element) {

            const passwordInput = element.previousElementSibling;
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            element.querySelector('i').classList.toggle('fa-eye');
            element.querySelector('i').classList.toggle('fa-eye-slash');

        };

        function closeModal(modalId){
            $(`#${modalId}`).modal('hide');


        }

        function workInProgress(){
            toastr.error("Work In Progresss");
        }

        // WebFont.load({
        //     google: {
        //         families: ["Public Sans:300,400,500,600,700"]
        //     },
        //     custom: {
        //         families: [
        //             "Font Awesome 5 Solid",
        //             "Font Awesome 5 Regular",
        //             "Font Awesome 5 Brands",
        //             "simple-line-icons",
        //         ],
        //         urls: ["assets/css/fonts.min.css"],
        //     },
        //     active: function() {
        //         sessionStorage.fonts = true;
        //     },
        // });
    </script>

    @yield('page-script')

</body>

</html>
