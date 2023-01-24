@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>{{ trans('global.change_password') }}</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("profile.password.update") }}">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.user.fields.email') }}</label>
                <input class="form-control" type="text" name="email" id="email" value="{{ old('email', auth()->user()->email) }}">
                @if($errors->has('email'))
                    <div class="text-danger">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="title">New {{ trans('cruds.user.fields.password') }}</label>
                <input class="form-control" type="password" name="password" id="password">
                @if($errors->has('password'))
                    <div class="text-danger">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="title">Repeat New {{ trans('cruds.user.fields.password') }}</label>
                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection