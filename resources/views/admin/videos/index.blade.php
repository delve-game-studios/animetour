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
                                <a href="{{ route($routes['back']) }}" class="btn btn-outline-danger">{{ __('videos.INDEX_BACK') }}</a>
                                <div class="card-header-actions">
                                    <a href="{{ route($routes['import'], $playlist) }}" class="btn btn-outline-success">{{ __('videos.INDEX_IMPORT') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-responsive-md table-striped">
                                            <thead>
                                            <tr>
                                                <th class="border-0" width="85%">{{ __('videos.INDEX_TITLE') }}</th>
                                                <th class="border-0 text-center">{{ __('videos.INDEX_LINK') }}</th>
                                                <th class="border-0 text-center">{{ __('videos.INDEX_VERIFIED') }}</th>
                                                <th class="border-0 text-center">{{ __('videos.INDEX_ACTIONS') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($videos as $item)
                                                <tr>
                                                    <td>{{ $item->title }}</td>
                                                    <td class="text-center">
                                                        <a href="/storage/{{ $item->entry }}" class="btn btn-primary" target="_blank">
                                                            <i class="icon-eye"></i>
                                                            {{ __('videos.INDEX_LINK_SUBST') }}
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ $item->verified ? 'javascript:void(0);' : route($routes['verify'], $item) }}" class="btn btn-{{ $item->verified ? 'success' : 'outline-warning' }} text-center">
                                                            <i class="icon-check"></i>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <button onclick="window.location = '{{ route($routes['delete'], $item) }}'" title="{{ __('videos.INDEX_DELETE') }}" class="btn btn-danger btn-ladda ladda-button" data-style="expand-right">
                                                            <span class="ladda-label">
                                                                <i class="icon-ban"></i>
                                                            </span>
                                                            <span class="ladda-spinner"></span>
                                                            <div class="ladda-progress" style="width: 0px;"></div>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-danger text-center">{{ __('videos.INDEX_NO_RESULTS') }}</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        {{ $videos->links() }}
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
