@extends('layouts.app')

@section('page-title', 'Profile Settings')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center">
            <i class="bi bi-person-gear text-blue-600 mr-3"></i>
            Profile Settings
        </h1>
        <p class="text-gray-600 mt-1">Manage your account settings and preferences</p>
    </div>

    <!-- Update Profile Information -->
    <div class="bg-white shadow-sm rounded-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="bi bi-person text-blue-600 mr-2"></i>
                Profile Information
            </h3>
            <p class="text-sm text-gray-600 mt-1">Update your account's profile information and email address.</p>
        </div>
        <div class="p-6">
            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <input id="name" 
                           name="name" 
                           type="text" 
                           value="{{ old('name', $user->name) }}" 
                           required 
                           autofocus 
                           autocomplete="name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('name') border-red-500 ring-2 ring-red-200 @enderror">
                    @error('name')
                        <div class="flex items-center mt-2 text-red-600">
                            <i class="bi bi-exclamation-circle mr-1 text-sm"></i>
                            <span class="text-sm">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           value="{{ old('email', $user->email) }}" 
                           required 
                           autocomplete="username"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('email') border-red-500 ring-2 ring-red-200 @enderror">
                    @error('email')
                        <div class="flex items-center mt-2 text-red-600">
                            <i class="bi bi-exclamation-circle mr-1 text-sm"></i>
                            <span class="text-sm">{{ $message }}</span>
                        </div>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-center text-yellow-800">
                                <i class="bi bi-exclamation-triangle mr-2"></i>
                                <span class="text-sm">Your email address is unverified.</span>
                            </div>
                            <button form="send-verification" 
                                    class="mt-2 text-sm text-yellow-600 hover:text-yellow-800 underline">
                                Click here to re-send the verification email.
                            </button>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-sm text-green-600">A new verification link has been sent to your email address.</p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" 
                            class="flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="bi bi-check-circle mr-2"></i>
                        Save Changes
                    </button>

                    @if (session('status') === 'profile-updated')
                        <div class="flex items-center text-green-600">
                            <i class="bi bi-check-circle mr-1"></i>
                            <span class="text-sm">Saved successfully!</span>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Update Password -->
    <div class="bg-white shadow-sm rounded-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="bi bi-shield-lock text-blue-600 mr-2"></i>
                Update Password
            </h3>
            <p class="text-sm text-gray-600 mt-1">Ensure your account is using a long, random password to stay secure.</p>
        </div>
        <div class="p-6">
            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('put')

                <!-- Current Password -->
                <div>
                    <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                    <input id="update_password_current_password" 
                           name="current_password" 
                           type="password" 
                           autocomplete="current-password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('current_password', 'updatePassword') border-red-500 ring-2 ring-red-200 @enderror">
                    @error('current_password', 'updatePassword')
                        <div class="flex items-center mt-2 text-red-600">
                            <i class="bi bi-exclamation-circle mr-1 text-sm"></i>
                            <span class="text-sm">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input id="update_password_password" 
                           name="password" 
                           type="password" 
                           autocomplete="new-password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('password', 'updatePassword') border-red-500 ring-2 ring-red-200 @enderror">
                    @error('password', 'updatePassword')
                        <div class="flex items-center mt-2 text-red-600">
                            <i class="bi bi-exclamation-circle mr-1 text-sm"></i>
                            <span class="text-sm">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input id="update_password_password_confirmation" 
                           name="password_confirmation" 
                           type="password" 
                           autocomplete="new-password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('password_confirmation', 'updatePassword') border-red-500 ring-2 ring-red-200 @enderror">
                    @error('password_confirmation', 'updatePassword')
                        <div class="flex items-center mt-2 text-red-600">
                            <i class="bi bi-exclamation-circle mr-1 text-sm"></i>
                            <span class="text-sm">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" 
                            class="flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="bi bi-shield-check mr-2"></i>
                        Update Password
                    </button>

                    @if (session('status') === 'password-updated')
                        <div class="flex items-center text-green-600">
                            <i class="bi bi-check-circle mr-1"></i>
                            <span class="text-sm">Password updated successfully!</span>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Account -->
    <div class="bg-white shadow-sm rounded-lg border border-red-200">
        <div class="px-6 py-4 border-b border-red-200 bg-red-50">
            <h3 class="text-lg font-semibold text-red-900 flex items-center">
                <i class="bi bi-exclamation-triangle text-red-600 mr-2"></i>
                Delete Account
            </h3>
            <p class="text-sm text-red-700 mt-1">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
        </div>
        <div class="p-6">
            <button onclick="document.getElementById('deleteModal').classList.remove('hidden')" 
                    class="flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                <i class="bi bi-trash mr-2"></i>
                Delete Account
            </button>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="bi bi-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Account</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted.
                    </p>
                </div>
                <form method="post" action="{{ route('profile.destroy') }}" class="mt-4">
                    @csrf
                    @method('delete')
                    
                    <div class="mb-4">
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               placeholder="Enter your password to confirm"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        @error('password', 'userDeletion')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="button" 
                                onclick="document.getElementById('deleteModal').classList.add('hidden')"
                                class="flex-1 px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-400 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="flex-1 px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition-colors">
                            Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Email Verification Form (hidden) -->
@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
    <form id="send-verification" method="post" action="{{ route('verification.send') }}" style="display: none;">
        @csrf
    </form>
@endif
@endsection