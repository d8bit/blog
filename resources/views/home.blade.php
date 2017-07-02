@extends('layouts.app')

@section('content')
    <div class="progress">
        <div id="progress-bar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
            <span class="sr-only">45% Complete</span>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    <div id="app"></div>
                    <div class="panel-body">
                        <App></App>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
