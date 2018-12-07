@extends('admin.manage')

@section('title', __('site.PAGE_PREFIX') . __('videos.PAGE_TITLE_IMPORTS'))

@section('form')
    <form action="{{ route($routes['store'], $playlist) }}" method="POST" enctype="multipart/form-data" class="form" files="true">
        @csrf
        <div class="form-body">
            <div class="row">
                <div class="col">
                    <label for="entry_type">{{ __('videos.LABEL_ENTRY_TYPE') }}</label>
                    <select name="entry_type" id="entry_type" class="form-control" required>
                        <option value="File" selected>{{ __('videos.ENTRY_TYPE_FILE') }}</option>
                        <option value="URL">{{ __('videos.ENTRY_TYPE_URL') }}</option>
                    </select>
                </div>
                <div class="col entry_type entry_file">
                    <label for="entry_file">{{ __('videos.LABEL_ENTRY_FILES') }}</label>
                    <input type="file" name="entry_file[]" id="entry_file" accept="video/*" class="form-control-file" multiple>
                </div>
                <div class="col entry_type entry_url d-none">
                    <label for="entry_url">{{ __('videos.LABEL_ENTRY_URLS') }}</label>
                    <textarea name="entry_url" id="entry_url" class="form-control-plaintext" placeholder="Separate URLs by new line"></textarea>
                </div>
            </div>
            <div class="row mt-4 mb-4"></div>
            <div class="row mt-3 justify-content-right">
                <div class="col form-footer">
                    <a href="{{ route($routes['index'], $playlist) }}" class="btn btn-danger">{{ __('videos.FORM_CANCEL') }}</a>
                    <button type="submit" class="btn btn-success">{{ __('videos.FORM_SUBMIT') }}</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    @parent
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#entry_type', function () {
                $('.col.entry_type.entry_file').toggleClass('d-none', this.value !== 'File');
                $('.col.entry_type.entry_url').toggleClass('d-none', this.value !== 'URL');
            });
        });
    </script>
@endsection
