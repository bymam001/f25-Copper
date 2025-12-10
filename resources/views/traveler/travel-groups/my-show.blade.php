<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $group->name }} – Group Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 space-y-10">

                {{-- Flash Message --}}
                @if (session('status'))
                    <div class="mb-4 text-green-600 font-semibold">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Group Overview --}}
                <section>
                    <h3 class="text-lg font-bold mb-4">Group Overview</h3>

                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <dt class="font-medium text-gray-700 dark:text-gray-300">Group Name</dt>
                            <dd class="text-gray-900 dark:text-gray-100">
                                {{ $group->name }}
                            </dd>
                        </div>

                        <div>
                            <dt class="font-medium text-gray-700 dark:text-gray-300">Created On</dt>
                            <dd class="text-gray-900 dark:text-gray-100">
                                {{ $group->created_at->format('M d, Y') }}
                            </dd>
                        </div>
                    </dl>
                </section>

                {{-- Invite Form --}}
                <section class="p-5 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">
                        Invite Someone to This Group
                    </h3>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="mb-3 text-red-500 text-sm">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('traveler.travel_groups.invite', $group) }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="email" class="block mb-2 text-gray-700 dark:text-gray-300">
                                Email Address
                            </label>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-100"
                                placeholder="friend@example.com"
                            >
                        </div>

                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                        >
                            Send Invitation
                        </button>
                    </form>
                </section>

                {{-- Invitations List --}}
                <section>
                    <h3 class="text-lg font-bold mb-3">Invitations for This Group</h3>

                    @if ($group->invitations && $group->invitations->count())
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($group->invitations as $invite)
                                <li class="py-3 flex justify-between items-center">
                                    <div>
                                        <p class="text-gray-900 dark:text-gray-100">{{ $invite->email }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ ucfirst($invite->status) }} • {{ $invite->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600 dark:text-gray-300">
                            No invitations have been sent for this group yet.
                        </p>
                    @endif
                </section>

                {{-- Planning Tools Placeholder --}}
                <section class="border-t pt-4">
                    <h3 class="text-lg font-bold mb-2">Planning Tools</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        Planning tools for this group (itineraries, voting, and approvals)
                        will appear here. For now, this page shows the basic details for
                        <span class="font-semibold">{{ $group->name }}</span>.
                    </p>
                </section>

                {{-- Back Link --}}
                <div>
                    <a href="{{ route('traveler.travel_groups.index') }}"
                       class="inline-block px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded hover:bg-gray-300 dark:hover:bg-gray-600">
                        ← Back to My Travel Groups
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
