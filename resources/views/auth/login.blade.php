@extends('layout')

@section('content')
  <h2 class="text-xl font-bold mb-4">Login</h2>

  <form method="POST" action="/login">
    @csrf
    <input name="email" placeholder="Email" class="w-full mb-2 border p-2">
    <input name="password" type="password" placeholder="Password" class="w-full mb-2 border p-2">
    <button class="bg-blue-500 text-white w-full py-2">Login</button>
  </form>

  <p class="mt-3 text-sm">Belum punya akun?
    <a href="/register" class="text-blue-500">Register</a>
  </p>
@endsection