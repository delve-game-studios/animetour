@extends('admin.app')

@section('content')

    <main class="main">
        <!-- Breadcrumb-->
        @include('admin.partials.breadcrumb')

        <div class="container-fluid">
            <div class="animated fadeIn">

                @include('admin.partials.alerts')

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-header-actions">
                                    <a href="{{ route($routes['create']) }}" class="btn btn-outline-success">{{ __('playlists.INDEX_CREATE') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-responsive-md table-striped">
                                            <thead>
                                            <tr>
                                                <th class="border-0">{{ __('playlists.INDEX_TITLE') }}</th>
                                                <th class="border-0 text-center">{{ __('playlists.INDEX_COUNT') }}</th>
                                                <th class="border-0 text-center">{{ __('playlists.INDEX_ACTIONS') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($playlists as $item)
                                                <tr>
                                                    <td>{{ $item->title }}</td>
                                                    <td class="text-center">
                                                        <span class="btn btn-{{ $item->videos->count() > 0 ? 'primary' : 'danger' }}">{{ $item->videos->count() }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route($routes['attach-videos'], $item) }}" title="{{ __('playlists.INDEX_ACTION_ATTACH') }}" class="btn btn-primary">
                                                            <ico class="icon-layers"></ico>
                                                        </a>
                                                        <a href="{{ route($routes['edit'], $item) }}" title="{{ __('playlists.INDEX_ACTION_EDIT') }}" class="btn btn-warning">
                                                            <ico class="icon-note"></ico>
                                                        </a>
                                                        <a href="{{ route($routes['delete'], $item) }}" title="{{ __('playlists.INDEX_ACTION_DELETE') }}" class="btn btn-danger">
                                                            <ico class="icon-ban"></ico>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-danger text-center">{{ __('playlists.INDEX_NO_RESULTS') }}</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        {{ $playlists->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
