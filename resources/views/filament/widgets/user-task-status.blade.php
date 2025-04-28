<div class="space-y-2">
    <div class="flex items-center justify-between">
        <span class="text-sm font-medium text-gray-500">Total Tasks</span>
        <span class="text-sm font-semibold">{{ $total }}</span>
    </div>
    <div class="space-y-1">
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500">To Do</span>
            <span class="text-sm font-medium text-yellow-600">{{ $todo }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500">In Progress</span>
            <span class="text-sm font-medium text-blue-600">{{ $in_progress }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500">Done</span>
            <span class="text-sm font-medium text-green-600">{{ $done }}</span>
        </div>
    </div>
</div> 