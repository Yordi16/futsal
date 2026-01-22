@extends('layouts.admin')

@section('content')
    <div class="space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 px-2 md:px-0">
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-slate-800 flex items-center gap-3">
                    <div
                        class="w-10 h-10 md:w-12 md:h-12 bg-indigo-500 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <i class="fas fa-users text-white text-sm md:text-xl"></i>
                    </div>
                    Kelola User
                </h1>
                <p class="text-slate-500 font-medium mt-3 text-sm md:text-base">
                    Data user yang terdaftar di sistem
                </p>
            </div>

            <div class="bg-white px-6 py-4 rounded-[1.5rem] border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="w-10 h-10 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div>
                    <span class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 block">
                        Total User
                    </span>
                    <div class="text-xl font-black text-slate-800 leading-none">
                        {{ $users->total() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE CONTAINER --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            {{-- Wrapper untuk scroll horizontal di mobile --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[800px]">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-400">
                            <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest">Info User
                            </th>
                            <th class="px-6 py-5 text-center text-[10px] font-black uppercase tracking-widest">Email
                            </th>
                            <th class="px-6 py-5 text-center text-[10px] font-black uppercase tracking-widest">No.
                                Telepon
                            </th>
                            <th class="px-6 py-5 text-center text-[10px] font-black uppercase tracking-widest">Tanggal
                                Daftar</th>
                            <th class="px-6 py-4 text-center text-[9px] font-black uppercase tracking-widest">Detail
                            </th>
                    </thead>

                    <tbody class="divide-y divide-slate-50">
                        @forelse ($users as $user)
                            <tr class="hover:bg-indigo-50/30 transition-all group">
                                {{-- USER --}}
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-black shadow-md shadow-indigo-100">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-700 text-base">{{ $user->name }}</div>
                                            <div class="text-[10px] text-indigo-500 font-bold uppercase tracking-tight">ID
                                                Member #{{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- EMAIL --}}
                                <td class="px-6 py-5 text-center">
                                    <span class="px-3 py-1.5 bg-slate-100 rounded-lg font-medium text-slate-600 text-xs">
                                        {{ $user->email }}
                                    </span>
                                </td>

                                {{-- PHONE --}}
                                <td class="px-6 py-5 text-center font-bold text-slate-600">
                                    {{ $user->phone ?? '-' }}
                                </td>

                                {{-- CREATED --}}
                                <td class="px-6 py-5 text-center">
                                    <div class="text-slate-700 font-bold text-xs">{{ $user->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-[9px] text-slate-400 font-medium">
                                        {{ $user->created_at->diffForHumans() }}
                                    </div>
                                </td>

                                {{-- DETAIL --}}
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.daftaruser.order', $user->id) }}"
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-50 border border-slate-200 hover:bg-indigo-50 hover:border-indigo-200 transition-all group">
                                        <i class="fas fa-arrow-right text-slate-400 group-hover:text-indigo-500"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-24">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-4 text-2xl">
                                            <i class="fas fa-user-slash"></i>
                                        </div>
                                        <span class="text-slate-400 font-black uppercase tracking-widest text-xs">
                                            Tidak ada data user terdaftar
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        </div>

    </div>
@endsection
