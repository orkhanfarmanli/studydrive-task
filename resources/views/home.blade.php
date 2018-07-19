@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- Check the status of the account and set the text and its color --}}
                <div class="card-header text-{{ auth()->user()->active ? 'success' : 'danger' }}">
                    Your account is {{ auth()->user()->active ? 'activated!' : 'not activated!' }}
                </div>
                <div class="card-body">
                    <p>{{ auth()->user()->email }} is logged in!</p>
                    <p>Your user id is: {{ auth()->user()->id }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection