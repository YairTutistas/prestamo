@extends('welcome')
@section('title', 'Create company')

@section('content_header')
    <h1>{{__('Create company')}}</h1>
@stop

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-danger">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{route('saveCompany')}}" method="POST" class="mt-5">
            @csrf
            <div class="col-md-12 mb-3">
                <label for="name">{{__('Name company')}}</label>
                <input type="text" class="form-control" name="name" placeholder="Name company" required>
            </div>
            <button class="btn btn-primary form-control">{{__('Save')}}</button>
        </form>

    </div>
@stop
@push('css')
    <style>
        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(2.25rem + 2px);
        }
    </style>
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            $('#client').select2();
        });
    </script>
@endpush