@extends('layout')

@section('content')
<h2 class="text-xl font-bold mb-4">Register</h2>

<form method="POST" action="/register">
@csrf
<input name="name" placeholder="Nama" class="w-full mb-2 border p-2">
<input name="email" placeholder="Email" class="w-full mb-2 border p-2">
<input name="password" type="password" placeholder="Password" class="w-full mb-2 border p-2">
<button class="bg-green-500 text-white w-full py-2">Register</button>
</form>
@endsection
