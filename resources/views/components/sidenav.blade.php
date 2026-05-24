<aside class="w-64 bg-gray-900 text-gray-100 min-h-screen shadow-xl">
    <div class="p-6 text-2xl font-black text-indigo-400 border-b border-gray-800 tracking-tighter">BIRRAMA HR</div>
    <nav class="mt-6 px-4">
        <div class="text-xs font-bold text-gray-500 uppercase mb-4 px-2 tracking-widest">Core</div>
        <ul class="space-y-1">
            <li><a href="/dashboard" class="flex items-center px-4 py-2 hover:bg-gray-800 rounded-md transition">Dashboard</a></li>

            @can('employee.create')
            <li><a href="/employees" class="flex items-center px-4 py-2 hover:bg-gray-800 rounded-md transition">Employee Directory</a></li>
            @endcan

            @can('payroll.initiate')
            <li><a href="/payroll" class="flex items-center px-4 py-2 hover:bg-gray-800 rounded-md transition">Payroll Runs</a></li>
            @endcan
        </ul>

        <div class="text-xs font-bold text-gray-500 uppercase mt-8 mb-4 px-2 tracking-widest">Self Service</div>
        <ul class="space-y-1">
            <li><a href="/leave" class="flex items-center px-4 py-2 hover:bg-gray-800 rounded-md transition">My Leave</a></li>
            <li><a href="/timesheets" class="flex items-center px-4 py-2 hover:bg-gray-800 rounded-md transition">My Timesheets</a></li>
            <li><a href="/my-benefits" class="flex items-center px-4 py-2 hover:bg-gray-800 rounded-md transition">My Benefits</a></li>
        </ul>

        @canany(['leave.approve_manager', 'timesheet.approve_supervisor'])
        <div class="text-xs font-bold text-gray-500 uppercase mt-8 mb-4 px-2 tracking-widest">Management</div>
        <ul class="space-y-1">
            @can('leave.approve_manager')
            <li><a href="/leave/approvals" class="flex items-center px-4 py-2 hover:bg-gray-800 rounded-md transition">Leave Approvals</a></li>
            @endcan
            @can('timesheet.approve_supervisor')
            <li><a href="/timesheets/approvals" class="flex items-center px-4 py-2 hover:bg-gray-800 rounded-md transition">Timesheet Approvals</a></li>
            @endcan
        </ul>
        @endcanany

        <div class="text-xs font-bold text-gray-500 uppercase mt-8 mb-4 px-2 tracking-widest">Talent & Operations</div>
        <ul class="space-y-1">
            <li><a href="/recruitment" class="flex items-center px-4 py-2 hover:bg-gray-800 rounded-md transition">Recruitment</a></li>
            <li><a href="/training" class="flex items-center px-4 py-2 hover:bg-gray-800 rounded-md transition">Training</a></li>
            @can('employee.purge')
            <li><a href="/offboarding" class="flex items-center px-4 py-2 hover:bg-gray-800 rounded-md transition">Offboarding</a></li>
            @endcan
        </ul>

        @role('Super Admin')
        <div class="text-xs font-bold text-gray-500 uppercase mt-8 mb-4 px-2 tracking-widest">System</div>
        <ul class="space-y-1">
            <li><a href="/settings" class="flex items-center px-4 py-2 hover:bg-gray-800 rounded-md transition font-mono text-xs">Settings</a></li>
        </ul>
        @endrole
    </nav>
</aside>
