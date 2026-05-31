<x-admin.layout>
    <x-slot:title>User Registry</x-slot:title>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm rounded-r-lg">
            <p class="text-xs font-black uppercase tracking-widest mb-1">Success Alert</p>
            <p class="text-sm font-bold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">User Registry</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">Authorized Personnel & Stakeholder Directory</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <form action="{{ route('admin.users') }}" method="GET" class="relative group">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs group-focus-within:text-ferti-green transition-colors"></i>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search by name or email..." 
                       class="bg-white border border-gray-200 rounded-full py-2.5 pl-9 pr-4 text-xs w-64 shadow-sm focus:ring-2 focus:ring-ferti-green/20 focus:border-ferti-green transition-all outline-none">
                @if(request('search'))
                    <a href="{{ route('admin.users') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </a>
                @endif
            </form>

            <a href="{{ route('admin.users.create') }}" 
            class="bg-ferti-green text-white px-5 py-2.5 text-xs font-bold rounded-lg shadow-md hover:shadow-lg hover:brightness-110 flex items-center gap-2 uppercase tracking-widest transition-all">
                <i class="fa-solid fa-user-plus"></i> Add New User
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Identity</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Designation</th>
                        <!-- <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Territory</th> -->
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-cream/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-ferti-green text-white flex items-center justify-center font-bold text-xs shadow-inner">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 group-hover:text-ferti-green transition-colors">{{ $user->name }}</p>
                                        <p class="text-[10px] text-gray-500 font-medium">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="text-[9px] font-black px-2.5 py-1 rounded-md uppercase tracking-wider border
                                    {{ $user->role === 'admin' 
                                        ? 'bg-purple-50 text-purple-700 border-purple-100' 
                                        : 'bg-blue-50 text-blue-700 border-blue-100' }}">
                                    {{ $user->role ?? 'Stakeholder' }}
                                </span>
                            </td>

                            <!-- <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot text-gray-300 text-[10px]"></i>
                                    <p class="text-xs font-bold text-gray-600 uppercase tracking-tighter">
                                        {{ $user->state ?? 'National' }}
                                    </p>
                                </div>
                            </td> -->

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                    </span>
                                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-[0.1em]">Active</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    
                                    <a href="{{ route('admin.users.show', $user->id) }}" 
                                    title="View Profile" 
                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                        <i class="fa-solid fa-eye text-sm"></i>
                                    </a>

                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                    title="Edit User" 
                                    class="p-2 text-gray-400 hover:text-ferti-green hover:bg-green-50 rounded-lg transition-all">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                                        onsubmit="return confirm('Are you sure you want to revoke access for this user? This action cannot be undone.');" 
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete User" 
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fa-solid fa-user-slash text-4xl text-gray-200 mb-4"></i>
                                    <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">No personnel matching your criteria</p>
                                    <a href="{{ route('admin.users') }}" class="text-xs text-ferti-green font-bold underline mt-2 uppercase tracking-tighter">Clear all filters</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-5 bg-gray-50/50 border-t border-gray-100">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</x-admin.layout>