@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">新規登録画面</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">名前</label>
                <input id="name" type="text" name="name" required autofocus
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                       value="{{ old('name') }}">
                @error('name')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">メールアドレス</label>
                <input id="email" type="email" name="email" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                       value="{{ old('email') }}">
                @error('email')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">パスワード</label>
                <input id="password" type="password" name="password" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                @error('password')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">パスワード確認</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            </div>

            <!-- Submit Button -->
            <div class="flex flex-col items-center">
                <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 mb-4">
                    新規登録
                </button>
                @if (Route::has('login'))
                    <a href="{{ route('login') }}"
                       class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        ログイン
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection