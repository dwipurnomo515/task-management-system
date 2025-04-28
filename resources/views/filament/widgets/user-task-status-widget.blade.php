<x-filament::widget>
    <x-filament::card>
        <div class="p-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">User Task Status</h3>
                <div class="flex items-center space-x-2">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search users..."
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    />
                </div>
            </div>

            @php
                $aggregate = $this->getAggregateStats();
            @endphp

            <div class="mb-6 grid grid-cols-1 md:grid-cols-6 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Tasks</h4>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $aggregate['total_tasks'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">To Do</h4>
                    <p class="text-2xl font-semibold text-yellow-600">{{ $aggregate['total_todo'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">In Progress</h4>
                    <p class="text-2xl font-semibold text-blue-600">{{ $aggregate['total_in_progress'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Done</h4>
                    <p class="text-2xl font-semibold text-green-600">{{ $aggregate['total_done'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Overdue</h4>
                    <p class="text-2xl font-semibold text-red-600">{{ $aggregate['total_overdue'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Upcoming (7 days)</h4>
                    <p class="text-2xl font-semibold text-orange-600">{{ $aggregate['total_upcoming'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($this->getPaginatedUsers() as $user)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">{{ $user->name }}</h4>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Total Tasks</span>
                                <span class="text-sm font-semibold">{{ $user->todo_count + $user->in_progress_count + $user->done_count }}</span>
                            </div>
                            <div class="space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">To Do</span>
                                    <span class="text-sm font-medium text-yellow-600">{{ $user->todo_count }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">In Progress</span>
                                    <span class="text-sm font-medium text-blue-600">{{ $user->in_progress_count }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">Done</span>
                                    <span class="text-sm font-medium text-green-600">{{ $user->done_count }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">Overdue</span>
                                    <span class="text-sm font-medium text-red-600">{{ $user->overdue_count }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">Upcoming (7 days)</span>
                                    <span class="text-sm font-medium text-orange-600">{{ $user->upcoming_count }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if($this->getTotalPages() > 1)
                <div class="mt-4 flex justify-center">
                    <div class="flex space-x-2">
                        @for($i = 1; $i <= $this->getTotalPages(); $i++)
                            <button
                                wire:click="$set('page', {{ $i }})"
                                class="px-3 py-1 rounded-md {{ $this->getCurrentPage() == $i ? 'bg-primary-500 text-white' : 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}"
                            >
                                {{ $i }}
                            </button>
                        @endfor
                    </div>
                </div>
            @endif
        </div>
    </x-filament::card>
</x-filament::widget> 