<div class="chat {{ $class }}">

    <div class='chat-avatar'>
        <div class="avatar bg-light-primary d-flex justify-content-center pt-3">
            <div class="avatar-content">{{ $name[0] }}</div>
        </div>
    </div>
    <div class='chat-body'>
        <div class='chat-content'>
            <p>
                {{-- @if (auth()->gaurd('admin')->user()->getRoleNames()[0] == 'Admin')
                    @php $role="Admin"; @endphp;
                @else
                    @php $role="Moderator"; @endphp;
                @endif --}}
                {{-- @if (auth('web')->check())
                    @if ($overallrole == 'youngrads_consultant')
                        <span class="d-block " style="font-size: 11px;">
                            {{ $name }} {{ '(' }} {{ 'Youngrads Consultant' }} {{ ')' }}

                        </span>
                    @else
                        <span class="d-block " style="font-size: 11px;">
                            {{ $name }} {{ '(' }} {{ 'students' }} {{ ')' }}

                        </span>
                    @endif
                @else
                    <span class="d-block " style="font-size: 11px;">
                        {{ $name }} {{ '(' }} {{ $row->role_name ?? 'N/A' }} {{ ')' }}
                        {{ '(' }} {{ $row->username ?? 'N/A' }} {{ ')' }}
                    </span>
                @endif --}}

                <span class="d-block " style="font-size: 11px;">
                    {{ $name }} {{ '(' }} {{ $overallrole ?? 'N/A' }} {{ ')' }}

                </span>




                {{ $row->message }}
                <span class=" pt-50 ml-1" style="font-size: 11px;">
                    {{ date('d M Y h:i A', strtotime($row->time)) }}
                </span>
            </p>
            {{-- @if ($row->is_important == 0)
                <button class='btn btn-important d-none' data-id="{{ $row->id }}" title="Mark as Important">
                    <i class='feather icon-heart pink text-danger'></i>
                </button>
            @else
                <button class='btn btn-important d-none' data-id="{{ $row->id }}">
                    <i class='fa fa-heart  text-danger text-danger'></i>
                </button>
            @endif --}}
            @if ($row->file)
                <a class="{{ $attchmentClass }}" href="{{ asset('message_documents/' . $row->file) }} " download> <i
                        class='fa fa-paperclip' aria-hidden='true'></i> Attachment</a>
            @endif
        </div>
    </div>
</div>
