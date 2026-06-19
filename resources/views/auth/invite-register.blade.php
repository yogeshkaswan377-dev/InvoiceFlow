<x-guest-layout>
    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Accept Invitation</h2>
        <p class="text-sm text-gray-600 mb-4">You've been invited to join as <strong>{{ ucfirst($invite->role) }}</strong></p>

        <form method="POST" action="{{ route('invite.register', $invite->token) }}">
            @csrf
            <input type="text" name="name" placeholder="Your Name" class="w-full border rounded px-3 py-2 mb-3" required>
            <input type="email" value="{{ $invite->email }}" class="w-full border rounded px-3 py-2 mb-3 bg-gray-100" disabled>
            <input type="password" name="password" placeholder="Password" class="w-full border rounded px-3 py-2 mb-3" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full border rounded px-3 py-2 mb-4" required>
            <button class="w-full bg-blue-600 text-white px-4 py-2 rounded">Accept & Register</button>
        </form>
    </div>
</x-guest-layout>