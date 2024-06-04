@extends('welcome')

@section('title', 'Users')

@section('content_header')
    <h1>{{__('Users')}}</h1>
@stop

@section('content')
<div class="container">
    <div class="col-12 d-flex justify-content-end">
        <a href="{{route('register')}}" class="btn btn-secondary mb-5">{{__('Create')}}</a>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <table id="users" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>{{__('Username')}}</th>
                <th>{{__('Email')}}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th>{{$user->name}}</th>
                    <th>{{$user->email}}</th>
                    <th>
                        <div class="row">
                            <a class="btn btn-primary mr-1" href="{{ route("editUser", Crypt::encryptString($user->id)) }}"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('profile.destroy', Crypt::encryptString($user->id)) }}" method="POST" id="delete-form-{{ $user->id }}">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="submit" class="btn btn-danger mr-1" data-id="{{ $user->id }}" form="delete-form-{{ $user->id }}"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop
@push('styles')
    <!-- DataTables CSS -->
    <link href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!-- Initialize DataTables -->
    <script>
    $(document).ready(function() {
        $('#users').DataTable();
    });
    </script>
@endpush