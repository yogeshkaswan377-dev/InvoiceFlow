<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">System Logs</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between mb-4">
                        <p class="text-sm text-gray-500">Last 100 log entries</p>
                        <a href="{{ route('super-admin.logs') }}" class="text-blue-600 text-sm">Refresh</a>
                    </div>

                    <div class="bg-gray-900 text-gray-100 rounded-lg p-4 overflow-x-auto max-h-96 overflow-y-auto font-mono text-xs">
                        @forelse($logs as $line)
                        <div class="py-0.5 {{ str_contains($line, 'ERROR') ? 'text-red-400' : (str_contains($line, 'WARNING') ? 'text-yellow-400' : 'text-gray-300') }}">
                            {{ $line }}
                        </div>
                        @empty
                        <p class="text-gray-500">No logs found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>