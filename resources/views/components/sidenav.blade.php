<aside class="w-64 bg-slate-900 text-slate-300 h-screen flex flex-col flex-shrink-0 shadow-2xl">
    <div class="p-8 flex items-center gap-3">
        <div class="h-8 w-8 bg-indigo-500 rounded-lg flex items-center justify-center text-white font-black">B</div>
        <span class="text-xl font-extrabold tracking-tighter text-white">BIRRAMA</span>
    </div>

    <nav class="flex-1 px-4 overflow-y-auto custom-scrollbar">
        <div class="space-y-8">
            <div>
                <div class="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-4">Core Platform</div>
                <ul class="space-y-1">
                    <x-nav-link href="/dashboard" icon="home" label="Overview" />
                    @can('employee.create')
                        <x-nav-link href="/employees" icon="users" label="Personnel" />
                    @endcan
                    @can('payroll.initiate')
                        <x-nav-link href="/payroll" icon="cash" label="Payroll" />
                    @endcan
                    @can('report.export')
                        <x-nav-link href="/reports" icon="chart-bar" label="Analytics" />
                    @endcan
                </ul>
            </div>

            <div>
                <div class="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-4">Self Service</div>
                <ul class="space-y-1">
                    <x-nav-link href="/profile" icon="user-circle" label="My Profile" />
                    <x-nav-link href="/leave" icon="calendar" label="My Leave" />
                    <x-nav-link href="/timesheets" icon="clock" label="Timesheets" />
                    <x-nav-link href="/my-benefits" icon="gift" label="Benefits" />
                </ul>
            </div>

            @canany(['leave.approve_manager', 'timesheet.approve_supervisor'])
            <div>
                <div class="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-4">Management</div>
                <ul class="space-y-1">
                    @can('leave.approve_manager') <x-nav-link href="/leave/approvals" icon="check-badge" label="Approvals" /> @endcan
                    @can('benefit.catalog') <x-nav-link href="/benefits/assign" icon="plus-circle" label="Assign Benefits" /> @endcan
                </ul>
            </div>
            @endcanany

            <div>
                <div class="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-4">Organization</div>
                <ul class="space-y-1">
                    <x-nav-link href="/recruitment" icon="briefcase" label="Recruitment" />
                    <x-nav-link href="/training" icon="academic-cap" label="Learning" />
                    @can('employee.purge') <x-nav-link href="/offboarding" icon="user-minus" label="Offboarding" /> @endcan
                </ul>
            </div>
        </div>
    </nav>

    <div class="p-4 border-t border-slate-800 bg-slate-900/50">
        <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-red-500/10 hover:text-red-500 transition-all font-bold text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Sign Out
            </button>
        </form>
    </div>
</aside>
