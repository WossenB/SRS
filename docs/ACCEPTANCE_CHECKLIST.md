# Acceptance Checklist

## Foundation
- [ ] Audit logs capture updates and deletes.
- [ ] Status logs track workflow transitions.
- [ ] Optimistic locking prevents concurrent edits.

## Payroll
- [ ] Ethiopian tax slabs correctly applied.
- [ ] Pension calculated at 7% (employee) and 11% (employer).
- [ ] Idempotency: Multiple regular runs for same month blocked.

## Leave & Attendance
- [ ] Leave overlap validation functional.
- [ ] Leave balance validation functional.
- [ ] Timesheets require at least one entry for submission.

## Security
- [ ] Salary/TIN fields are encrypted in DB.
- [ ] Document downloads restricted by role.
