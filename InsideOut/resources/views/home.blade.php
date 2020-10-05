@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
                <div class="card-footer">
                    <a  class="btn" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<a href="{{URL::to('logout')}}" class="btn btn-danger btn-sm">Logout</a>
@endsection
