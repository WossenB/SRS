<aside class="w-64 bg-gray-800 text-white min-h-screen">
    <div class="p-4 text-xl font-bold border-b border-gray-700">Birrama HRMS</div>
    <nav class="mt-4">
        <ul>
            <li class="px-4 py-2 hover:bg-gray-700"><a href="/dashboard">Dashboard</a></li>

            @can('employee.create')
            <li class="px-4 py-2 hover:bg-gray-700"><a href="/employees">Employees</a></li>
            @endcan

            @can('payroll.initiate')
            <li class="px-4 py-2 hover:bg-gray-700"><a href="/payroll">Payroll</a></li>
            @endcan

            <li class="px-4 py-2 hover:bg-gray-700"><a href="/leave">My Leave</a></li>
            @can('leave.approve_manager')
            <li class="px-4 py-2 hover:bg-gray-700 font-semibold text-gray-400">Manager</li>
            <li class="px-4 py-2 hover:bg-gray-700"><a href="/approvals/leave">Leave Approvals</a></li>
            @endcan

            <li class="px-4 py-2 hover:bg-gray-700"><a href="/timesheets">My Timesheets</a></li>

            @can('applicant.manage')
            <li class="px-4 py-2 hover:bg-gray-700"><a href="/recruitment">Recruitment</a></li>
            @endcan

            @can('performance.cycle_manage')
            <li class="px-4 py-2 hover:bg-gray-700"><a href="/performance">Performance</a></li>
            @endcan

            @role('Super Admin')
            <li class="px-4 py-2 hover:bg-gray-700"><a href="/settings">System Settings</a></li>
            <li class="px-4 py-2 hover:bg-gray-700"><a href="/audit">Audit Logs</a></li>
            @endrole
        </ul>
    </nav>
</aside>
