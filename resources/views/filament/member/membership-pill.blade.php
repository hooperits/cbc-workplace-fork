@php
    use App\Enums\MembershipState;

    $member = auth('member')->user();
    $approved = $member && $member->membership_state === MembershipState::APPROVED;
    $label = $approved ? 'Afiliado' : 'Registrado';
    $classes = $approved
        ? 'bg-teal-500/15 text-teal-300 border-teal-500/30'
        : 'bg-slate-700/40 text-slate-300 border-slate-600/40';
@endphp
<span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-[11px] font-semibold tracking-wide uppercase {{ $classes }}">
    {{ $label }}
</span>
