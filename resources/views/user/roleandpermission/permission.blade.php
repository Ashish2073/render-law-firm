@php
   

    $crud = ['view', 'add', 'edit', 'delete', 'N/A', 'N/A'];

    $allaction = ['view', 'add', 'edit', 'delete', 'assign', 'dissociate'];

    $all_permissions = [
        'dashboard' => ['view', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A'],

        'roles_and_permissions' => $crud,
        'customers' => $crud,
        'customer_status'=>['N/A','N/A','edit','N/A','N/A','N/A']
    ];

@endphp


    <div class="form-group">
        <label for="toggle-permissions">
            <input id='toggle-permissions' type="checkbox"> Select/Deselect all
        </label>
    </div>





    <div class="container mt-5">
        <h2>Permission Table</h2>
        <table class="table table-bordered">
            <thead>

                <tr>
                    <td>Website Section</td>

                    <td style="padding: 0px 20px;">
                        @foreach ($allaction as $value)
                            <div class="form-check form-check-inline px-1">
                                {{ ucfirst($value) }}

                            </div>
                        @endforeach
                    </td>

                </tr>


            </thead>
            <tbody>

                @foreach ($all_permissions as $key => $value)
                    <tr>

                        <td>
                            <label for="{{ ucfirst($key) }}">

                                <input name="permissions_heading[]" value="" data-parent="{{ $key }}"
                                    {{ havePermission($role ?? '', $key) ? 'checked' : '' }} class="parent-item"
                                    id="{{ $key }}" type="checkbox">
                                {{ ucfirst($key) }}
                            </label>

                        </td>


                        <td>
                            @foreach ($value as $k => $val)
                                @if ($val != 'N/A')
                                    <div class="form-check form-check-inline">
                                        <input  type="checkbox" id="{{ $key . '_' . $val }}"
                                            value="{{ $key . '_' . $val }}" data-child="{{ $key }}"
                                            {{ havePermission($role ?? '', $key . '_' . $val) ? 'checked' : '' }}  
                                         style="border-color: black;"   name="permissions[]">
                                        {{-- <label class="form-check-label" for="{{ $key . '_' . $val }}"></label> --}}
                                    </div>
                                @else
                                    <div class="form-check form-check-inline">
                                        {{-- <i class='fas fa-times-circle'></i> --}}
                                        <input  type="checkbox" id="" disabled
                                            value=""
                                           
                                         style="border-color: black;"   name="permissions[]">
                                    </div>
                                @endif
                            @endforeach
                        </td>

                    </tr>
                @endforeach
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
