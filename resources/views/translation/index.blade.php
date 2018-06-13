@extends('layouts.app')
@section('content')
    <div class="container" id="message">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Translation <span class="btn btn-primary">{{ Auth::id() }}</span></div>

                    <div class="card-body">
                        <translation-component
                                :translation_id="{{ Auth::id() }}"
                        ></translation-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<script src="/js/app.js"></script>--}}
@endsection