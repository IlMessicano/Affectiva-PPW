@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">Upload Video</div>

            <div class="card-body">
                @if ($message = Session::get('success'))

                    <div class="alert alert-success alert-block">

                        <button type="button" class="close" data-dismiss="alert">×</button>

                        <strong>{{ $message }}</strong>

                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> Ci sono problemi con l'input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/save-video-upload') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="file" class="form-control-file" name="nomeVideo[]" id="nomeVideo" multiple="">
                        <div class="preview"></div>   <!--for preview purpose -->
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Carica</button>
                </form>

            </div>
        </div>
    <form method="POST" action="{{ action('VideoController@destroy') }}">
        @csrf
        @foreach($video as $video)
            <label><input type="radio" name="checked" value="{{$video->id}}">{{$video->nomeVideo}}</label>
        @endforeach
        <button type="submit">Elimina</button>
    </form>
    </div>


<script>
    $(function() {
        // Multiple images preview in browser
        var imagesPreview = function(input, placeToInsertImagePreview) {

            if (input.files) {
                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        $($.parseHTML('<img style="width: 150px">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    }

                    reader.readAsDataURL(input.files[i]);
                }
            }

        };

        $('#nomeVideo').on('change', function() {
            imagesPreview(this, 'div.preview');
        });
    });
    </script>
@endsection
