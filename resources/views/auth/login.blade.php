@extends('layouts.app')

@section('title', __('Authorization'))

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-6 offset-3">
                {!! Form::open(['route' => 'login', 'method' => 'POST']) !!}
                <div class="form-group">
                    {!! Form::label('email', __('Email')) !!}
                    {!! Form::email('email', old('email'), [
                            'class' => $errors->has('email') ? 'form-control is-invalid' : 'form-control',
                    ]) !!}
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::label('password', __('Password')) !!}
                    {!! Form::password('password', [
                            'class' => $errors->has('password') ? 'form-control is-invalid' : 'form-control' ,
                    ]) !!}
                    @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('remember',  old('remember')) !!}
                            {{ __('Remember me') }}
                        </label>
                    </div>
                </div>
                <div class="form-group pull-right">
                    <a href="{{ redirect()->getUrlGenerator()->previous() }}"
                       class="btn btn-default">{{ __('Return') }}</a>
                    {!! Form::submit(__('Login'), ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest(\App\Http\Requests\LoginRequest::class) !!}
@endsection