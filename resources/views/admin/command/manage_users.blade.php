@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-3xl font-semibold mb-6 text-gray-800">Manage Users</h2>

    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="min-w-full table-auto text-left text-sm text-gray-500">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 font-semibold text-gray-700">Name</th>
                    <th class="px-6 py-3 font-semibold text-gray-700">Email</th>
                    <th class="px-6 py-3 font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-3 font-semibold text-gray-700">Activated At</th>
                    <th class="px-6 py-3 font-semibold text-gray-700">Expiration</th>
                    <th class="px-6 py-3 font-semibold text-gray-700">DB Status</th>
                    <th class="px-6 py-3 font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span id="user-status-{{ $user->id }}" class="{{ $user->is_active ? 'text-green-600 font-semibold' : 'text-yellow-500 font-semibold' }}">
                                {{ $user->is_active ? 'Active' : 'Pending Verification' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->activated_at ? $user->activated_at->format('Y-m-d H:i') : '—' }}
                        </td>
                        <td class="px-6 py-4">
                            <span id="countdown-{{ $user->id }}" class="text-sm font-semibold">
                                @if($user->expires_at)
                                    {{ $user->expires_at->diffInSeconds(Carbon\Carbon::now()) > 0 ? $user->expires_at->diffForHumans() : 'Expired' }}
                                @else
                                    No expiration set
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs {{ $user->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="status-toggle-{{ $user->id }}" class="toggle-status rounded border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500" data-user-id="{{ $user->id }}" {{ $user->is_active ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Toggle</span>
                            </label>
                            @if(!$user->is_active)
                                <button class="ml-4 text-sm text-blue-500 underline" onclick="verifyUser({{ $user->id }})">Verify & Activate</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Countdown Timer for Expiration (now handles days)
    function updateCountdown(userId, expiresAt) {
        const countdownElement = document.getElementById('countdown-' + userId);

        if (!countdownElement) return;

        let expiresAtTime = new Date(expiresAt).getTime();

        function refreshCountdown() {
            let now = new Date().getTime();
            let distance = expiresAtTime - now;

            if (distance <= 0) {
                countdownElement.innerText = "Expired";
                deactivateUser(userId); // Automatically deactivate if expired
                return;
            }

            let days = Math.floor(distance / (1000 * 60 * 60 * 24));
            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownElement.innerText = `${days}d ${hours}h ${minutes}m ${seconds}s`;

            setTimeout(refreshCountdown, 1000);
        }

        refreshCountdown();
    }

    function deactivateUser(userId) {
        fetch('{{ route('admin.command.update_user_status') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ user_id: userId, is_active: false })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const statusText = document.getElementById('user-status-' + userId);
                statusText.textContent = 'Inactive';
                statusText.classList.remove('text-green-600');
                statusText.classList.add('text-gray-500');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to deactivate user.');
        });
    }

    function verifyUser(userId) {
        fetch('{{ route('admin.command.verify_user') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ user_id: userId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const statusText = document.getElementById('user-status-' + userId);
                statusText.textContent = 'Active';
                statusText.classList.remove('text-yellow-500');
                statusText.classList.add('text-green-600');
                location.reload();
            } else {
                alert('Failed to verify and activate user.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong.');
        });
    }

    document.querySelectorAll('.toggle-status').forEach(toggle => {
        toggle.addEventListener('change', function () {
            const userId = this.getAttribute('data-user-id');
            const isActive = this.checked ? 1 : 0;

            fetch('{{ route('admin.command.update_user_status') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ user_id: userId, is_active: isActive })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const statusText = document.getElementById('user-status-' + userId);
                    statusText.textContent = isActive ? 'Active' : 'Pending Verification';
                    statusText.classList.toggle('text-green-600', isActive);
                    statusText.classList.toggle('text-yellow-500', !isActive);
                    location.reload();
                } else {
                    alert('Failed to update status.');
                    this.checked = !this.checked;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong.');
                this.checked = !this.checked;
            });
        });
    });

    @foreach ($users as $user)
        @if ($user->expires_at)
            updateCountdown({{ $user->id }}, '{{ $user->expires_at }}');
        @endif
    @endforeach
</script>
@endsection
