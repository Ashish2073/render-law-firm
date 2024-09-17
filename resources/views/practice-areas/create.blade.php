@extends('layouts.app')

@section('title', 'Pratice Areas')

@section('content')

<!-- load breadcrumb and pass values -->
<x-breadcrumb :breadcrumbs="$breadcrumbs" ></x-breadcrumb>

<div class="w-full mx-auto">
    <form action="{{ route('admin.practice-areas.store') }}" method="POST">
        @csrf
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" autocomplete="off" name="name" id="name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required value="{{ old('name') }}" />
            <label for="name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Name</label>
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <textarea type="password" autocomplete="off" name="description" id="description" class="h-32 block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" >{{ old('description') }}</textarea>
            <label for="description" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Description</label>
        </div>
        <div class="relative z-10 w-full mb-5 group">
            <input type="hidden" name="parent_id" value="{{ old('parent_id') }}" />
            <input type="text" autocomplete="off" name="parent" id="parent" value="{{ old('parent') }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="parent" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Parent</label>
            <div class="absolute w-96">
                <ul id="parent-list" class="z-10">
                </ul>
            </div>
        </div>
        <div class="relative z-0 w-full mb-5 group"">
            <label class="inline-flex items-center mb-5 cursor-pointer">
                @if(old('status'))
                    <input type="checkbox" name="status" value="1" class="sr-only peer" checked>
                @else
                    <input type="checkbox" name="status" value="1" class="sr-only peer">
                @endif
                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Status</span>
            </label>
        </div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $(document).on('click', function(e) {
            if(!$(e.target).closest('#parent-list').length && !$(e.target).is('#parent')) {
                $('#parent-list').html('');
            }
        });

        $('#parent').on('click keyup', function() {
            let name = $(this).val();
            $.ajax({
                url: "{{ route('admin.practice-areas.search') }}",
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name
                },
                success: function(response) {
                    if(response.success) {
                        $('#parent-list').html('');
                        response.practiceAreas.forEach(function(item) {
                            $('#parent-list').append('<li class="bg-gray-100 dark:bg-gray-800 py-2 px-3 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700" data-id="'+item.id+'" data-name="'+item.name+'">'+item.name+'</li>');
                        });
                        $('#parent-list li').on('click', function() {
                            $('#parent').val($(this).data('name'));
                            $('input[name="parent_id"]').val($(this).data('id'));
                            $('#parent-list').html('');
                        });
                    }
                }
            });
        });
    })
</script>

@endsection