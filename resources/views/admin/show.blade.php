<x-admin.layout>
    <x-slot:title>User Profile | {{ $user->name }}</x-slot:title>

    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('admin.users') }}" class="text-xs font-bold text-gray-400 hover:text-ferti-green transition-all uppercase tracking-widest flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to Registry
            </a>
            <div class="flex gap-3">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-white border border-gray-200 text-gray-700 px-4 py-2 text-xs font-bold rounded-lg shadow-sm hover:bg-gray-50 flex items-center gap-2 uppercase tracking-widest">
                    <i class="fa-solid fa-pen"></i> Edit Profile
                </a>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="h-32 bg-ferti-green relative">
                <div class="absolute -bottom-12 left-8 p-1 bg-white rounded-2xl shadow-sm">
                    <div class="w-24 h-24 rounded-xl bg-cream text-ferti-green flex items-center justify-center text-3xl font-black border-2 border-white">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                </div>
            </div>

            <div class="pt-16 p-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $user->name }}</h1>
                        <p class="text-sm text-gray-500 font-medium">{{ $user->email }}</p>
                    </div>
                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border 
                        {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700 border-purple-100' : 'bg-blue-50 text-blue-700 border-blue-100' }}">
                        {{ $user->role }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Primary Territory</p>
                        <p class="text-sm font-bold text-gray-800">{{ $user->state ?? 'Not Assigned' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Account Status</p>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            <p class="text-sm font-bold text-gray-800">Verified & Active</p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Registry Date</p>
                        <p class="text-sm font-bold text-gray-800">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-gray-50 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-cream/50 p-4 rounded-2xl flex items-center gap-4">
                        <div class="p-3 bg-white rounded-xl text-ferti-green shadow-sm">
                            <i class="fa-solid fa-file-contract text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Active Transactions</p>
                            <p class="text-lg font-bold text-ferti-green">0 Units</p>
                        </div>
                    </div>
                    <div class="bg-cream/50 p-4 rounded-2xl flex items-center gap-4">
                        <div class="p-3 bg-white rounded-xl text-ferti-green shadow-sm">
                            <i class="fa-solid fa-truck-fast text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Distribution Points</p>
                            <p class="text-lg font-bold text-ferti-green">Global</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>