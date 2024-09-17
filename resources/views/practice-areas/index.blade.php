@extends('layouts.app')

@section('title', 'Pratice Areas')

@section('content')

<!-- load breadcrumb and pass values -->
<x-breadcrumb :breadcrumbs="$breadcrumbs" ></x-breadcrumb>

<div class="w-full">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Practice Areas</h1>
        <div class="flex justify-end">
            <a href="{{ route('admin.practice-areas.create') }}" class="flex items-center mr-1 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-200 dark:focus:ring-blue-500" type="button">
                <i class="fa-solid fa-plus"></i>
            </a>
            <button type="button" href="{{ route('admin.practice-areas.create') }}" class="flex items-center mr-1 px-4 py-2 text-sm font-medium text-white bg-gray-500 rounded-md hover:bg-gray-300 focus:outline-none focus:ring focus:ring-gray-400 dark:bg-gray-700 dark:focus:ring-gray-500" type="button" data-drawer-target="filter-drawer" data-drawer-show="filter-drawer" data-drawer-placement="right" aria-controls="filter-drawer">
                <i class="fa-solid fa-filter"></i>
            </button>
            <button type="button" class="flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring focus:ring-red-200 dark:focus:ring-red-500" type="button">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    </div>
</div>

<div id="filter-drawer" class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-right-label">
    <div class="mt-16 p-2">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Filter</h1>
            <button type="button" class="focus:outline-none" data-drawer-hide="filter-drawer">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form action="{{ route('admin.practice-areas') }}" method="GET">
            @if(request()->has('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @else
                <input type="hidden" name="sort" value="id">
            @endif
            @if(request()->has('order'))
                <input type="hidden" name="order" value="{{ request('order') }}">
            @else
                <input type="hidden" name="order" value="desc">
            @endif
            <div class="mb-4">
                <label for="name" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-400">Name</label>
                <input type="text" name="name" id="name" class="w-full px-3 py-2 border dark:bg-gray-700 dark:border-gray-600" placeholder="Name">
            </div>
            <div class="mb-4">
                <label for="parent" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-400">Parent</label>
                <select name="parent" id="parent" class="w-full px-3 py-2 border dark:bg-gray-700 dark:border-gray-600">
                    <option value="">Select Parent</option>
                    @foreach($parentPracticeAreas as $practiceArea)
                        @if(request()->has('parent') && request('parent') == $practiceArea->id)
                            <option value="{{ $practiceArea->id }}" selected>{{ $practiceArea->name }}</option>
                        @else
                            <option value="{{ $practiceArea->id }}">{{ $practiceArea->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="status" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-400">Status</label>
                <select name="status" id="status" class="w-full px-3 py-2 border dark:bg-gray-700 dark:border-gray-600">
                    <option value="">Select Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div class="flex justify-between">
                <a href="{{ route('admin.practice-areas') }}" type="button" class="px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring focus:ring-gray-200 dark:focus:ring-gray-500" type="button">
                    Reset
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-200 dark:focus:ring-blue-500" type="button">
                    Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="p-4">
                    <div class="flex items-center">
                        <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-all" class="sr-only">checkbox</label>
                    </div>
                </th>
                @php
                    $currentQuery = request()->except(['sort', 'direction']);
                @endphp
                <th scope="col" class="px-6 py-3">
                    Name
                    <span class="ml-1">
                        @if(request()->has('sort') && request('sort') == 'name')
                            @if(request()->has('order') && request('order') == 'asc')
                            <a href="{{ url('admin/practice-areas') }}?{{ http_build_query(array_merge($currentQuery, ['sort' => 'name', 'order' => 'desc'])) }}" >
                                <i class="fa-solid fa-sort-alpha-down"></i>
                            </a>
                            @else
                            <a href="{{ url('admin/practice-areas') }}?{{ http_build_query(array_merge($currentQuery, ['sort' => 'name', 'order' => 'asc'])) }}" >
                                <i class="fa-solid fa-sort-alpha-up"></i>
                            </a>
                            @endif
                        @else
                            <a href="{{ url('admin/practice-areas') }}?{{ http_build_query(array_merge($currentQuery, ['sort' => 'name', 'order' => 'asc'])) }}" >
                                <i class="fa-solid fa-sort-alpha-up"></i>
                            </a>
                        @endif
                    </span>
                </th>
                <th scope="col" class="px-6 py-3">
                    Description
                </th>
                <th scope="col" class="px-6 py-3">
                    Parent
                    <span class="ml-1">
                        @if(request()->has('sort') && request('sort') == 'parent_id')
                            @if(request()->has('order') && request('order') == 'asc')
                            <a href="{{ url('admin/practice-areas') }}?{{ http_build_query(array_merge($currentQuery, ['sort' => 'parent_id', 'order' => 'desc'])) }}" >
                                <i class="fa-solid fa-arrow-up"></i>
                            </a>
                            @else
                            <a href="{{ url('admin/practice-areas') }}?{{ http_build_query(array_merge($currentQuery, ['sort' => 'parent_id', 'order' => 'asc'])) }}" >
                                <i class="fa-solid fa-arrow-up"></i>
                            </a>
                            @endif
                        @else
                            <a href="{{ url('admin/practice-areas') }}?{{ http_build_query(array_merge($currentQuery, ['sort' => 'parent_id', 'order' => 'asc'])) }}" >
                                <i class="fa-solid fa-arrow-up"></i>
                            </a>
                        @endif
                    </span>
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                    <span class="ml-1">
                        @if(request()->has('sort') && request('sort') == 'status')
                            @if(request()->has('order') && request('order') == 'asc')
                            <a href="{{ url('admin/practice-areas') }}?{{ http_build_query(array_merge($currentQuery, ['sort' => 'status', 'order' => 'desc'])) }}" >
                                <i class="fa-solid fa-arrow-up"></i>
                            </a>
                            @else
                            <a href="{{ url('admin/practice-areas') }}?{{ http_build_query(array_merge($currentQuery, ['sort' => 'status', 'order' => 'asc'])) }}" >
                                <i class="fa-solid fa-arrow-up"></i>
                            </a>
                            @endif
                        @else
                            <a href="{{ url('admin/practice-areas') }}?{{ http_build_query(array_merge($currentQuery, ['sort' => 'status', 'order' => 'asc'])) }}" >
                                <i class="fa-solid fa-arrow-up"></i>
                            </a>
                        @endif
                    </span>
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @if($practiceAreas->count() > 0)
                @foreach($practiceAreas as $practiceArea)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $practiceArea->name }}
                        </th>
                        <td class="px-6 py-4 w-96">
                            {{ Str::limit($practiceArea->description, 50) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $practiceArea->parent->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($practiceArea->status)
                                <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-200">
                                    Active
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-200">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4" colspan="6">
                        <div class="flex items-center justify-center">
                            <span class="text-gray-500 dark:text-gray-400">No data found</span>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

@if($practiceAreas->count() > 0)
    <div class="mt-4">
        {{ $practiceAreas->links() }}
    </div>
@endif

<script>
    @if(Session::has('success'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        let message = "{{ session('success') }}";
        toastr.success(message);
    @endif
</script>

<script>
    $(document).ready(function() {
        $('#checkbox-all').click(function() {
            if ($(this).is(':checked')) {
                $('input[type=checkbox]').prop('checked', true);
            } else {
                $('input[type=checkbox]').prop('checked', false);
            }
        });
    });
</script>

@endsection