<style>
    .modal {
        /* z-index: 9999999!important; */
    }

    .modal .modal-dialog-aside {
        /* width: 500px; */
        width: 75%;
        max-width: 100%;
        height: 100%;
        margin: 0;
        transform: translate(0);
        transition: transform .2s;

    }

    .modal .modal-dialog-aside .modal-content {
        height: inherit;
        border: 0;
        border-radius: 0;
    }

    .modal .modal-dialog-aside .modal-content .modal-body {
        overflow-y: auto
    }

    .modal.fixed-left .modal-dialog-aside {
        margin-left: auto;
        transform: translateX(100%);
    }

    .modal.fixed-right .modal-dialog-aside {
        margin-right: auto;
        transform: translateX(-100%);
    }

    .modal.show .modal-dialog-aside {
        transform: translateX(0);
    }

    .modal-dialog-aside .modal-header .close {
        margin: 0rem 0rem 0rem auto;
    }
</style>
<style>
    .chat-application .content-area-wrapper .content-right .content-wrapper {
        padding: 0;
    }

    .chat-application .content-area-wrapper {
        border: 1px solid #dae1e7;
        border-radius: 0.25rem;
    }

    .chat-application .chat-profile-sidebar {
        border-right: 1px solid #E4E7ED;
        height: calc(100vh - 13rem);
        height: calc(var(--vh, 1vh) * 100 - 13rem);
        width: 400px;
        border-radius: 0.25rem;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        margin: 0;
        background-color: #fff;
        position: fixed;
        transform: translateX(-110%);
        transition: all 0.3s ease;
        z-index: 6;
    }

    .chat-application .chat-profile-sidebar.show {
        transform: translateX(0);
        transition: all 0.3s ease;
    }

    .chat-application .chat-profile-sidebar .chat-profile-header {
        display: flex;
        text-align: center;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    }

    .chat-application .chat-profile-sidebar .chat-profile-header .header-profile-sidebar {
        margin: 2rem auto 0.5rem;
    }

    .chat-application .chat-profile-sidebar .chat-profile-header .avatar {
        margin-bottom: 1.25rem;
    }

    .chat-application .chat-profile-sidebar .chat-profile-header .close-icon {
        position: absolute;
        top: 14px;
        right: 13px;
        font-size: 1.75rem;
        cursor: pointer;
    }

    .chat-application .chat-profile-sidebar .profile-sidebar-area .scroll-area {
        padding: 2rem;
        height: calc(100vh - 24.25rem);
        height: calc(var(--vh, 1vh) * 100 - 24.25rem);
        position: relative;
    }

    .chat-application .sidebar-content {
        border-right: 1px solid #E4E7ED;
        height: calc(100vh - 13rem);
        height: calc(var(--vh, 1vh) * 100 - 13rem);
        width: 400px;
        border-radius: 0.25rem;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        margin: 0;
        box-shadow: none;
    }

    .chat-application .sidebar-content .sidebar-close-icon {
        position: absolute;
        right: 0.25rem;
        top: 0.25rem;
        font-size: 1.25rem;
        z-index: 1;
        cursor: pointer;
        visibility: hidden;
    }

    .chat-application .sidebar-content .chat-fixed-search {
        position: fixed;
        width: 400px;
        border-bottom: 1px solid #E4E7ED;
        padding: 0.65rem;
    }

    .chat-application .sidebar-content .chat-fixed-search .sidebar-profile-toggle .avatar {
        display: inline-table;
        width: calc(32px + 8px);
    }

    .chat-application .sidebar-content .chat-fixed-search input.form-control {
        padding: 0.9rem 1rem 0.9rem 3rem;
        height: calc(1.25em + 1.4rem + 4px);
    }

    .chat-application .sidebar-content .chat-fixed-search .form-control-position {
        top: 5px;
    }

    .chat-application .sidebar-content .chat-fixed-search .form-control-position i {
        left: 9px;
    }

    .chat-application .sidebar-content .chat-user-list {
        height: calc(100% - 5rem);
        margin-top: 5rem;
        width: 400px;
    }

    .chat-application .sidebar-content .chat-user-list ul {
        padding-left: 0;
        margin-bottom: 0;
    }

    .chat-application .sidebar-content .chat-user-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.322rem 0.85rem;
        margin-right: 1px;
    }

    .chat-application .sidebar-content .chat-user-list li:not(:first-child) {
        border-top: 1px solid #E4E7ED;
    }

    .chat-application .sidebar-content .chat-user-list li .user-chat-info {
        width: 100%;
        display: flex;
        justify-content: space-between;
        overflow: hidden;
    }

    .chat-application .sidebar-content .chat-user-list li .contact-info {
        width: calc(100vw - (100vw - 100%) - 1rem - 50px);
        margin-top: 0.3rem;
    }

    .chat-application .sidebar-content .chat-user-list li .contact-info .truncate {
        margin: 0;
    }

    .chat-application .sidebar-content .chat-user-list li:hover {
        cursor: pointer;
        background: #eee;
    }

    .chat-application .sidebar-content .chat-user-list li.active {
        background: linear-gradient(118deg, #ff9f43, rgba(255, 159, 67, 0.7));
        box-shadow: 0 15px 30px 0 rgba(0, 0, 0, 0.11), 0 5px 15px 0 rgba(0, 0, 0, 0.08);
        color: #fff;
    }

    .chat-application .sidebar-content .chat-user-list li.active h1,
    .chat-application .sidebar-content .chat-user-list li.active h2,
    .chat-application .sidebar-content .chat-user-list li.active h3,
    .chat-application .sidebar-content .chat-user-list li.active h4,
    .chat-application .sidebar-content .chat-user-list li.active h5,
    .chat-application .sidebar-content .chat-user-list li.active h6 {
        color: #fff;
    }

    .chat-application .sidebar-content .chat-user-list li img {
        border: 2px solid #fff;
    }

    .chat-application .sidebar-content .card {
        margin-bottom: 0;
    }

    .chat-application .chat-overlay {
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        position: absolute;
        display: block;
        z-index: 2;
        visibility: hidden;
        border-radius: 0.25rem;
    }

    .chat-application .chat-overlay.show {
        visibility: visible;
        background-color: rgba(0, 0, 0, 0.2);
    }

    .chat-application .chat-app-window .favorite,
    .chat-application .chat-app-window .sidebar-toggle {
        cursor: pointer;
    }

    .chat-application .chat-app-window .user-chats {
        padding: 20px 30px;
        position: relative;
        text-align: center;
        height: calc(100vh - 23.5rem);
        height: calc(var(--vh, 1vh) * 100 - 23.5rem);
    }

    .chat-application .chat-app-window .start-chat-area,
    .chat-application .chat-app-window .user-chats {
        background-image: url(/images/chat-bg.svg?464708c291f0046e92cb7a6d708d7159);
        background-color: #dfdbe5;
    }

    .chat-application .chat-app-window .start-chat-area {
        height: calc(100vh - 13rem);
        height: calc(var(--vh, 1vh) * 100 - 13rem);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .chat-application .chat-app-window .start-chat-area .start-chat-icon,
    .chat-application .chat-app-window .start-chat-area .start-chat-text {
        background: white;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.12), 0 2px 4px 0 rgba(0, 0, 0, 0.08) !important;
    }

    .chat-application .chat-app-window .start-chat-area .start-chat-text {
        border-radius: calc(0.5rem * 4);
        cursor: pointer;
    }

    .chat-application .chat-app-window .start-chat-area .start-chat-icon {
        border-radius: 50%;
        font-size: 4rem;
        padding: 2rem;
    }

    .chat-application .chat-app-form {
        padding: 20px 10px;
        background-color: white;
    }

    .chat-application .chats {
        padding: 0;
    }

    .chat-application .chats .chat-body {
        display: block;
        margin: 10px 30px 0 0;
        overflow: hidden;
    }

    .chat-application .chats .chat-body .chat-content {
        text-align: right;
        display: block;
        float: right;
        padding: 0.75rem 1rem;
        margin: 0 20px 10px 0;
        clear: both;
        color: #fff;
        background: linear-gradient(118deg, #ff9f43, rgba(255, 159, 67, 0.7));
        border-radius: 0.5rem;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.12), 0 2px 4px 0 rgba(0, 0, 0, 0.08);
    }

    .chat-application .chats .chat-body .chat-content p {
        margin: 0;
    }

    .chat-application .chats .chat-avatar {
        float: right;
    }

    .chat-application .chats .chat-left .chat-avatar {
        float: left;
    }

    .chat-application .chats .chat-left .chat-body {
        margin-right: 0;
        margin-left: 30px;
    }

    .chat-application .chats .chat-left .chat-content {
        text-align: left;
        float: left;
        margin: 0 0 10px 20px;
        color: #626262;
        background: none;
        background-color: white;
    }

    .chat-application .user-profile-sidebar {
        border-right: 1px solid #E4E7ED;
        height: calc(100vh - 13rem);
        height: calc(var(--vh, 1vh) * 100 - 13rem);
        width: 400px;
        border-radius: 0.25rem;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        margin: 0;
        background-color: #fff;
        position: fixed;
        transform: translateX(110%);
        transition: all 0.3s ease;
        z-index: 6;
        right: 4.2rem;
        bottom: 5.25rem;
        opacity: 0;
    }

    .chat-application .user-profile-sidebar.show {
        opacity: 1;
        transform: translateX(7%);
        transition: all 0.3s ease;
    }

    .chat-application .user-profile-sidebar .user-profile-header {
        display: flex;
        text-align: center;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    }

    .chat-application .user-profile-sidebar .user-profile-header .header-profile-sidebar {
        margin: 2rem auto 0.5rem;
    }

    .chat-application .user-profile-sidebar .user-profile-header .avatar {
        margin-bottom: 1.25rem;
    }

    .chat-application .user-profile-sidebar .user-profile-header .close-icon {
        position: absolute;
        top: 14px;
        right: 13px;
        font-size: 1.75rem;
        cursor: pointer;
    }

    .chat-application .user-profile-sidebar .user-profile-sidebar-area {
        height: calc(100vh - 24.25rem);
        height: calc(var(--vh, 1vh) * 100 - 24.25rem);
        position: relative;
    }

    @media (max-width: 767.98px) {
        .chat-application .chat-app-window {
            height: calc(100% - 132px);
        }

        .chat-application .sidebar-content .sidebar-close-icon {
            visibility: visible;
        }
    }

    @media (max-width: 575.98px) {
        .chat-application .sidebar-content {
            width: 260px;
            left: -4px !important;
        }

        .chat-application .sidebar-content .chat-fixed-search,
        .chat-application .sidebar-content .chat-user-list {
            width: 260px;
        }

        .chat-application .chat-profile-sidebar {
            width: 260px;
        }

        .chat-application .user-profile-sidebar {
            width: 260px;
            right: 2.35rem;
        }
    }

    @media (max-width: 991.98px) {
        .content-right {
            width: 100%;
        }

        .chat-application .sidebar-content {
            transform: translateX(-110%);
            transition: all 0.3s ease-in-out;
            left: 0;
            position: fixed;
            z-index: 5;
            left: -2px;
        }

        .chat-application .sidebar-content.show {
            transform: translateX(8.5%);
            transition: all 0.3s ease;
            display: block;
        }
    }

    @media (max-width: 349.98px) {
        .chat-application .sidebar-content {
            width: 230px;
            left: -2px !important;
        }

        .chat-application .sidebar-content .chat-fixed-search,
        .chat-application .sidebar-content .chat-user-list {
            width: 230px;
        }

        .chat-application .chat-profile-sidebar {
            width: 230px;
        }

        .chat-application .user-profile-sidebar {
            width: 230px;
        }
    }
</style>
</style>
<!-- Modal -->
<div class="modal fade fixed-left fade pr-0" id="dynamic-modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog modal-dialog-aside" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title dynamic-title" id="myModalLabel2"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body dynamic-body">

            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->





{{-- <div id="{{ $modal_id ?? 'inputId' }}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="{{ $modal_id ?? 'inputId' }}ModalLabel">
                    {{ $modal_heading ?? 'Enter Lawyer Proficience' }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body">
                    <form id="{{ $input_form_id ?? 'lawyerProficienceForm' }}">
                        @csrf

                        <input type="hidden" name="id" value="" id="{{$hiddenInputFiled ??'lawyer_proficience_id'}}" />
                        <div class="form-group">
                            <label for="{{$inputlabelName ??'name'}}">
                                <h5>{{ $modal_label_name ?? 'Proficience Name' }}</h5>
                            </label>


                            <input type="text" class="form-control" id="{{ $input_id ?? 'name' }}"
                                name="{{ $input_name ?? 'name' }}">
                            <span class="text-danger small" id="{{ $input_name . '_error' ?? 'name_error' }}"></span>

                        </div>
                    </form>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="{{ $input_save_button ?? 'input_button_save' }}">Save
                    changes</button>
            </div>
        </div>
    </div>
</div> --}}
