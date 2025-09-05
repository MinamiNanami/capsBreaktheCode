@extends('layouts.admin')

@section('content')
<section id="logout" class="content-section hidden">
    <h2>Logout</h2>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Confirm Logout</button>
    </form>
</section>
@endsection
