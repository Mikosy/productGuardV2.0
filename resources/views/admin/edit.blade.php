<x-admin.layout>
    <x-slot:title>Edit User: {{ $user->name }}</x-slot:title>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8 border-b border-gray-50 bg-gray-50/50">
                <h2 class="text-xl font-bold text-gray-900">Modify Personnel Profile</h2>
                <p class="text-xs text-gray-500 mt-1 uppercase tracking-widest font-bold">Registry ID: #{{ $user->id }}</p>
            </div>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full bg-cream border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-ferti-green">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="w-full bg-cream border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-ferti-green">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Designation</label>
                        <select name="role" class="w-full bg-cream border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-ferti-green">
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Ministry Admin</option>
                            <option value="consumer" {{ $user->role == 'consumer' ? 'selected' : '' }}>Consumer</option>
                            <option value="depot_officer" {{ $user->role == 'depot_officer' ? 'selected' : '' }}>Depot Officer</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Assigned Territory</label>
                        <input type="text" name="state" value="{{ old('state', $user->state) }}" 
                               class="w-full bg-cream border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-ferti-green">
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-50 flex justify-end gap-3">
                    <a href="{{ route('admin.users') }}" class="px-6 py-2.5 text-xs font-bold text-gray-400 uppercase tracking-widest">Cancel</a>
                    <button type="submit" class="bg-ferti-green text-white px-8 py-2.5 text-xs font-bold rounded-lg shadow-md hover:brightness-110 uppercase tracking-widest transition-all">
                        Update Registry
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin.layout>