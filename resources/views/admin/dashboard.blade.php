@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h1 class="mb-4">Dashboard Admin</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Người dùng</h5>
                    <p class="display-6">150</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Bài đăng chờ duyệt</h5>
                    <p class="display-6">20</p>
                </div>
            </div>
        </div>
    </div>
@endsection