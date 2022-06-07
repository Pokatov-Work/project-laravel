<?php
?>
@if (Route::has('login'))
<div class="top-right links">
    <a href="/admin">Admin</a>
    @auth
        <a href="{{ url('/') }}">Home</a>
    @else
        <a href="{{ route('login') }}">Login</a>
        @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
        @endif
    @endauth
</div>
@endif
