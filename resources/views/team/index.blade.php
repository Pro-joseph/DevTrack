@extends('layouts.app')

@section('title', 'Team | DevTrack')
@section('page-title', 'Team')

@section('content')
<div class="space-y-8 animate-in fade-in duration-500">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h2 class="text-3xl font-bold text-on-surface">Team Members</h2>
                <span class="px-2.5 py-0.5 bg-primary/10 text-primary text-xs rounded-full font-bold">4 Members</span>
            </div>
            <p class="text-sm text-outline">Manage your team and assignments.</p>
        </div>
        <button class="flex items-center justify-center gap-2 bg-primary text-white px-6 py-2.5 rounded-lg font-bold text-sm hover:shadow-lg hover:bg-primary-container transition-all active:scale-95">
            <span class="material-symbols-outlined text-[20px]">person_add</span>
            Invite Member
        </button>
    </div>

    <!-- Team Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $members = [
                ['name' => 'Alex Dev', 'role' => 'Lead Developer', 'email' => 'alex@devtrack.com', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD_52dK_afz--YqBRZ_TfcjTF513Zk8v-q9mFsRTxR1eIDmi4knGOcGsYwpRi2kCe2frTBrXgE8RCtZFoKU5npNWyYjItk9bW-LiWnj2KmtxGKREonemlQ6a3_01vJ5aB4WHC58xiz5v1qtxI6J77GoJtVCBX9roaEN-R0R2CDmVfwNNgIOlMPWyLZCWSdpzwzGlGtOr_xAVnL2562pswPTlgJtfQGql7yHd_9wgmB0me7KXxcpaydP3VN7spUAkUVJ63JUSA8BEvz3', 'status' => 'online'],
                ['name' => 'Sarah Jenkins', 'role' => 'UX Designer', 'email' => 'sarah@devtrack.com', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBfaeZ8JEJxmWFFLnP12mVagn1SpGY9IaAw7LYduCIb-oESKF0Aj-_IkpbnlWSXHpDrsuUt-z7wmIG9Jk6Jm1HS-FchcZ2bv0Be44Q_0IgiZo7vECvpeay2BffMf9gwO4DW_Lw86pkD7VTDpUf65Sunohy6jdVPDrpTFv9gAsKLG7z5SvUv9tLVZBFIhxS1UySa0eAgjuDy0GpMGrTZ-6EOofBvKY1aOJ-l3UNrXk5bW_a0-eji6wQmX86XPiSDZraTazQV7BI_VNck', 'status' => 'online'],
                ['name' => 'Marcus Kim', 'role' => 'Backend Engineer', 'email' => 'marcus@devtrack.com', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBkh3sexpxTbIUU-zOnGyVOqB6w208Ln7sQr_nAybLWC1jH2ONJpfUKIDurepaEDi0BeBwoGW27VU5DtZAU1S2ZDnR0QA2PF0NyYwH-nnDmVtWH_Vg8bnyuNmKQ_GKI8U7-JeRWAvNYWsJbIlrVeEvfSEn4tRVUScv7ZyiainQ6PRBSBT5nM3Yg01FZLrTFZXcW5rxo9pjtTKecrkJPuiqNZEOaqwU3Dy8tCaUSbLMtlKyEsmZt6G_sc7Ekl-veLW96AOoil1Go0DCM', 'status' => 'away'],
                ['name' => 'Jane Smith', 'role' => 'Frontend Lead', 'email' => 'jane@devtrack.com', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCyB6aLDWb6LdTXNd1B8OrgRrHUU-plU5NU687gWaU0A0uVekIl7pjleup5y_ZHTem6I1xwp7Oh21BJtExq-jB0Wi5T6aCtuqU1b3fjK6WO5d7OUduzV9cOu3WGL6q6HGWNtse4ISrf8FB5Vs3WMHRSVqTmX1R_Y3x17fmO9fNoR8WDtpRXa_814AGvifqhA7ij70JhiHiNfWQYwr8eyH-YSYV_4DgCKFCi3fV3E6jiAWiKsHLAwj1o_Uk0Za_gy8m5DbobYN6yQMZR', 'status' => 'offline'],
            ];
        @endphp

        @foreach($members as $member)
        <div class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-start justify-between mb-4">
                <div class="relative">
                    <img class="w-14 h-14 rounded-full border-2 border-white ring-2 ring-outline-variant" src="{{ $member['img'] }}" alt="{{ $member['name'] }}">
                    <span class="absolute bottom-0 right-0 w-4 h-4 rounded-full border-2 border-white {{ $member['status'] === 'online' ? 'bg-green-500' : ($member['status'] === 'away' ? 'bg-yellow-500' : 'bg-gray-400') }}"></span>
                </div>
                <button class="text-outline hover:text-primary p-2 rounded-lg hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-[20px]">more_vert</span>
                </button>
            </div>
            <h3 class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors">{{ $member['name'] }}</h3>
            <p class="text-sm text-outline mb-3">{{ $member['role'] }}</p>
            <p class="text-xs text-on-surface-variant">{{ $member['email'] }}</p>
            <div class="flex items-center gap-2 mt-4 pt-4 border-t border-outline-variant">
                <button class="flex-1 py-2 text-sm font-medium text-outline hover:text-primary hover:bg-surface-container rounded-lg transition-colors">
                    View Profile
                </button>
                <button class="flex-1 py-2 text-sm font-medium bg-primary text-white rounded-lg hover:bg-primary-container transition-colors">
                    Message
                </button>
            </div>
        </div>
        @endforeach

        <!-- Add Member Card -->
        <div class="border-2 border-dashed border-outline-variant rounded-xl p-6 flex flex-col items-center justify-center text-center hover:bg-white hover:border-primary transition-all group cursor-pointer">
            <div class="w-14 h-14 rounded-full bg-surface-container-low flex items-center justify-center text-outline group-hover:bg-primary/10 group-hover:text-primary mb-4 transition-all">
                <span class="material-symbols-outlined text-3xl">person_add</span>
            </div>
            <p class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors">Add Member</p>
            <p class="text-xs text-outline px-4 mt-2">Invite a new team member to collaborate.</p>
        </div>
    </div>
</div>
@endsection