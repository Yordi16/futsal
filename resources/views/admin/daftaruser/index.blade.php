@extends('layouts.admin')

@section('content')
<div class="space-y-8">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-800 flex items-center gap-3">
                <i class="fas fa-users text-indigo-500"></i>
                Kelola User
            </h1>
            <p class="text-slate-500 font-medium mt-1">
                Data user yang terdaftar di sistem
            </p>
        </div>

        <div class="bg-indigo-50 px-6 py-3 rounded-2xl border border-indigo-100">
            <span class="text-[10px] font-black uppercase tracking-widest text-indigo-400">
                Total User
            </span>
            <div class="text-xl font-black text-indigo-700">
                {{ $users->count() }}
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-400">
                    <th class="px-6 py-4 text-left text-[9px] font-black uppercase tracking-widest">User</th>
                    <th class="px-6 py-4 text-center text-[9px] font-black uppercase tracking-widest">Email</th>
                    <th class="px-6 py-4 text-center text-[9px] font-black uppercase tracking-widest">No. Telpon</th>
                    <th class="px-6 py-4 text-center text-[9px] font-black uppercase tracking-widest">Tanggal Daftar</th>
                    <th class="px-6 py-4 text-center text-[9px] font-black uppercase tracking-widest">Detail</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-50">
                @forelse ($users as $user)
                    <tr class="hover:bg-slate-50 transition">
                        {{-- USER --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-black">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                    <div class="font-black text-slate-700">{{ $user->name }}</div>
                            </div>
                        </td>

                        {{-- EMAIL --}}
                        <td class="px-6 py-4 text-center font-medium text-slate-600">
                            {{ $user->email }}
                        </td>

                        {{-- PHONE --}}
                        <td class="px-6 py-4 text-center font-medium text-slate-600">
                            {{ $user->phone ?? '-' }}
                        </td>

                        {{-- CREATED --}}
                        <td class="px-6 py-4 text-center text-slate-500 text-xs">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.daftaruser.order', $user->id) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-50 border border-slate-200 hover:bg-indigo-50 hover:border-indigo-200 transition-all group">
                            <i class="fas fa-arrow-right text-slate-400 group-hover:text-indigo-500"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-20 text-slate-400 font-black uppercase tracking-widest">
                            Tidak ada data user
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
