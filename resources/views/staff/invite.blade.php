<x-app-layout>
    <x-slot name="header">Invite Staff</x-slot>
    <div class="py-12 max-w-2xl mx-auto">
        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4">@php echo session('success') @endphp</div>
        @endif

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-semibold mb-4">Send Invite</h3>
            <form method="POST" action="{{ route('staff.invite.send') }}">
                @csrf
                <input type="email" name="email" placeholder="Email address" class="w-full border rounded px-3 py-2 mb-3" required>
                <select name="role" class="w-full border rounded px-3 py-2 mb-3">
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Send Invite</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Pending Invites</h3>
            @forelse($invites as $invite)
            <div class="flex justify-between py-2 border-b text-sm">
                <span>{{ $invite->email }}</span>
                <span class="capitalize">{{ $invite->role }}</span>
            </div>
            @empty
            <p class="text-gray-500 text-sm">No pending invites.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>