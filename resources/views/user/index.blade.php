@extends('layouts.app')

@section('content')
@push('css-plugins')
<link rel="stylesheet" href="{{ asset('style.css') }}" />
@endpush

@include('components.navbar')

<!-- component -->
<div class="flex min-h-screen items-center justify-center">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-xl">
            <thead>
                <tr class="bg-blue-gray-100 text-gray-700">
                    <th class="py-3 px-4 text-left">No</th>
                    <th class="py-3 px-4 text-left">Nama</th>
                    <th class="py-3 px-4 text-left">Email</th>
                    <th class="py-3 px-4 text-left">Peran</th>
                    <th class="py-3 px-4 text-left">Tanggal Bergabung</th>
                </tr>
            </thead>
            <tbody class="text-blue-gray-900">
                @foreach($users as $user)
                    <tr class="border-b border-blue-gray-200">
                        <td class="py-3 px-4">1</td>
                        <td class="py-3 px-4">{{ $user->name }}</td>
                        <td class="py-3 px-4">{{ $user->email }}</td>
                        <td class="py-3 px-4">
                            @if($user->is_admin)
                                Admin
                            @else
                                Surveyor
                            @endif
                        </td>
                        <td class="py-3 px-4">{{ $user->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('components.footer')

@push('js-plugins')
@endpush
@endsection