@inject('attachment', 'App\Http\Controllers\Admin\CaseMessageController')


<ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
    <li class="nav-item"> 
        <button type="button" class="nav-link active" id="nav-chat-tab" data-bs-toggle="tab" data-bs-target="#nav-chat"
            role="tab" aria-controls="nav-chat" aria-selected="true">Chat</button>
    </li>
    <li class="nav-item">
        <button type="button" class="nav-link" id="nav-attachment-tab" data-bs-toggle="tab"
            data-bs-target="#nav-attachment" role="tab" aria-controls="nav-attachment" aria-selected="false">Shared
            Attachment</button>
    </li>
</ul>
<div class="tab-content pt-1">
    <div class="tab-pane fade show  active" id="nav-chat" role="tabpanel" aria-labelledby="nav-chat-tab">
        <div class="chat-app-form px-0">
            <form id="message-form" method="POST" action="" enctype="multipart/form-data">
                @csrf
                <div class="chat-app-input d-flex">
                    <input type="text" name="message"
                        class="form-control message mr-1  @error('message') {{ errCls() }} @enderror"
                        id="iconLeft4-1" placeholder="Type your message">
                    <button class="btn btn-icon btn-outline-primary attachment mr-1" type="button">
                        <i class="fa fa-paperclip " aria-hidden="true"></i>
                    </button>

                    <button type="submit" class="btn btn-icon btn-primary send" id="submit-btn"><i
                            class="fa fa-paper-plane-o"></i> </button>
                </div>
                <p class="text-left  mt-50" id="attachment-name"></p>
                <div class="form-group  mt-1 row pl-2 col-6 d-none">

                    <div class="custom-file">

                        <input type="file"
                            class="custom-file-input message-file-input @error('document') {{ errCls() }} @enderror"
                            name="document">
                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>

                    </div>
                </div>
                <div class="error-message">
                    @error('message')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <input type="hidden" name="id" value="{{ $id }}">
                <input type="hidden" name=""><input type="hidden" id="auth_id" name="auth_id" value="{{ $auth }}">
                <input type="hidden" name=""><input type="hidden" id="auth_gaurd" name="gaurd" value="{{ $gaurd }}">

                @error('document')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </form>
        </div>
        <div class="user-chats">
            <table id="chat-table" class="table" style="width:100%">
                <thead class="d-none">
                    <th>html</th>
                    <th>test</th>
                </thead>
                <tbody class="chats" id="chat{{$id}}">

                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-pane" id="nav-attachment" role="tabpanel" aria-labelledby="nav-attachment-tab">

        @include('case_message.attachment', [
            'attachments' => $attachment::sharedAttachment($id),
        ])

    </div>
</div>



<script>
    var cases_id = "{{ $id }}";


    Echo.channel('case-message-channel' )
        .listen('SendMessage', (data) => {
            console.log(data);
            console.log('New message for case ' + cases_id + ':', data.message);

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

            let auth_id = $("#auth_id").val();
            let auth_gaurd = $("#auth_gaurd").val();

           

            if (((data.messenger_id != auth_id) && (data.messenger_guard == auth_gaurd)) || 
                 ((data.messenger_id !=auth_id) && (data.messenger_guard != auth_gaurd)) || 
                 ((data.messenger_id == auth_id) && (data.messenger_guard != auth_gaurd))){     

                $(`#chat${data.cases_id}`).prepend(html);
            }


        });



    var messageTable;


    function initMessageScript(id) {

        $(".attachment").unbind("click");
        $(".attachment").click(function() {
            $(".message-file-input").click();
        });

        $(".message-file-input").unbind("change");
        $(".message-file-input").change(function(e) {
            $('#attachment-name').text(e.target.files[0].name);
            $("#attachment-name").html("<span class='badge badge-primary badge-pill'>" + e.target.files[0]
                .name +
                "<button type='button' class='btn btn-icon p-25 text-white clear-attachment'><i class='fa fa-times'></i></button></span>"
            );
            let fileInput = $(this);
            $(".clear-attachment").unbind("click");
            $(".clear-attachment").click(function() {
                fileInput.val('');
                $("#attachment-name").html("");
            });
        });

        messgeTable = $("#chat-table").DataTable({
            "processing": true,
            "serverSide": true,
            ajax: {
                url: "{{ url('admin/case/message/all') }}" + "/" + id,
                data: function(d) {


                }
            },
            dom: "tp",
            "order": [
                [1, "desc"]
            ],
            columns: [

                {
                    data: 'html'
                },
                {
                    data: 'time',
                    'visible': false
                }

            ],
            responsive: false,
            "language": {
                "emptyTable": "No messages yet!"
            },
            drawCallback: function(setting, data) {
                let setTime;
                clearTimeout(setTime);
                setTime = setTimeout(() => {
                    // messgeTable.draw('page');
                }, 10000);

            },

            aLengthMenu: [
                [10, 15, 20],
                [10, 15, 20]
            ],

            bInfo: false,
            pageLength: 7,
            initComplete: function(settings, json) {
                $(".dt-buttons .btn").removeClass("btn-secondary");
                $(".table-img").each(function() {
                    $(this).parent().addClass('product-img');
                });

                // setInterval(()=>{
                //   messgeTable.ajax.reload(null,false);
                //   },5000);
            }
        });

        // $('#message-form').validate({
        //     rules: {
        //         message: {
        //             required: true,
        //         },
        //         document: {
        //             extension: "png|jpg|docx|doc|pdf"
        //         }
        //     },
        //     errorPlacement: function(error, element) {
        //         if (element.hasClass('select')) {
        //             element = element.next();
        //         }
        //         element = $(".error-message");
        //         error.insertAfter(element);
        //     },
        //     messages: {
        //         // Custom messages can go here
        //     }
        // });


        // submitForm($('#message-form'), {
        //     beforeSubmit: function() {
        //         $("#submit-btn").attr('disabled', 'disabled');
        //         $("#submit-btn").html("<i class='fa fa-spin fa-spinner'></i>");
        //     },
        //     success: function(data) {
        //         messgeTable.draw();
        //         $('#message-form')[0].reset();
        //     },
        //     error: function(data) {
        //         toast("error", "Something went wrong.", "Error");
        //     },
        //     complete: function() {
        //         $("#submit-btn").html("<i class='fa fa-paper-plane-o'></i>");
        //         $("#submit-btn").removeAttr('disabled');
        //         $("#attachment-name").html("");
        //     }
        // });




        $("#submit-btn").off('click').on('click', function(e) {
            e.preventDefault();

            var formData = new FormData($('#message-form')[0]);




            $.ajax({
                url: "{{ route('admin.case-message-store') }}",
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                before: function() {
                    $("#submit-btn").attr('disabled', 'disabled');
                    $("#submit-btn").html("<i class='fa fa-spin fa-spinner'></i>");
                },
                success: (data) => {
                    messgeTable.draw();
                    $('#message-form')[0].reset();
                },
                error: function(xhr) {
                    if (xhr.status == 422) {
                        var errorMessage = xhr.responseJSON.errormessage;
                        toastr.error("Something went wrong");
                        for (fieldName in errorMessage) {
                            if (errorMessage.hasOwnProperty(fieldName)) {
                                $(`[id="${fieldName}_error"`).html(errorMessage[fieldName][0]);
                            }
                        }
                    }
                },
                complete: function() {
                    $("#submit-btn").html("<i class='fa fa-paper-plane-o'></i>");
                    $("#submit-btn").removeAttr('disabled');
                    $("#attachment-name").html("");
                }
            });
        });






    }
</script>
