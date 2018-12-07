@extends('admin.manage')

@section('title', __('site.PAGE_PREFIX') . __('playlists.PAGE_TITLE_CREATE'))

@section('form')
    <form action="{{ route($routes['update'], $playlist) }}" method="POST" enctype="multipart/form-data" class="form">
        @csrf
        @method('PUT')
        <div class="form-body">
            <div class="row">
                <div class="col">
                    <label for="title">{{ __('playlists.LABEL_TITLE') }}</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $playlist->title) }}">
                </div>
            </div>
            <div class="row border-bottom border-light mt-4 mb-4"></div>
            <div class="row mt-3 justify-content-right">
                <div class="col form-footer">
                    <a href="{{ route($routes['index']) }}" class="btn btn-danger">{{ __('playlists.FORM_CANCEL') }}</a>
                    <button type="submit" class="btn btn-success">{{ __('playlists.FORM_SUBMIT') }}</button>
                </div>
            </div>
        </div>
    </form>
@endsection
