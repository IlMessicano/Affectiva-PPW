@extends('layouts.project')

@section('button')
    <div class="col-4">
        <button class="btn btn-block btn_new">
            <div class="row">
                <div class="col-12 text-center">
                    Project
                </div>
                <div class="col-12 text-center">
                    <i class="fas fa-plus"></i>
                </div>
            </div>
        </button>
    </div>

    <div class="col-4">
        <button class="btn btn-block  btn_new">
            <div class="row">
                <div class="col-12 text-center">
                    Task
                </div>
                <div class="col-12 text-center">
                    <i class="fas fa-plus"></i>
                </div>
            </div>
        </button>
    </div>
    <div class="col-4">
        <button class="btn btn-block btn_new">
            <div class="row">
                <div class="col-12 text-center">
                    Video
                </div>
                <div class="col-12 text-center">
                    <i class="fas fa-plus"></i>
                </div>
            </div>
        </button>
    </div>
@endsection
