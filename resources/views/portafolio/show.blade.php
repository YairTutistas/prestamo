@extends('welcome')
@section('title', 'Create portafolio')

@section('content_header')
    <h1>{{__('Show portafolio')}}</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{route('updatePortafolio', $portafolio)}}" method="POST">
            @csrf
            <div class="col-md-12 mt-3">
                <label for="name">{{__('Name')}}</label>
                <input type="text" name="name" id="name" placeholder="Name" value="{{$portafolio->name}}" class="form-control" required>
            </div>
            <div class="col-md-12 mt-3">
                <label for="user">{{ __('User') }}</label>
                <select name="user_id" id="user" class="form-control" required>
                    @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary form-control mt-5 col-md-12">{{__('Update')}}</button>
        </form>
    </div>
@stop
@push('js')
    <script>
        $(document).ready(function() {
            $('#user').select2();
        });
    </script>
@endpush
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