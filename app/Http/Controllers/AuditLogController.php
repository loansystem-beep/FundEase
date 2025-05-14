<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Staff;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    // Show all audit logs
    public function index()
    {
        $auditLogs = AuditLog::with('staff') // Load staff relation
            ->latest()
            ->paginate(10); // Paginate logs for easier navigation

        return view('audit.logs.index', compact('auditLogs')); // Pass logs to the index view
    }

    // Show a specific audit log
    public function show(AuditLog $auditLog)
    {
        return view('audit.logs.show', compact('auditLog')); // Detailed view for a specific log
    }

    // Show the form to create a new audit log
    public function create()
    {
        // Load staff members for the select dropdown
        $staff = Staff::all();
        
        return view('audit.logs.create', compact('staff')); // Pass staff data to the create view
    }

    // Store a new audit log entry
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'staff_id' => 'required|exists:staff,id', // Ensure staff exists
            'action' => 'required|string|max:255', // Action to be logged
            'auditable_type' => 'required|string|max:255', // Type of model being audited
            'auditable_id' => 'required|integer', // ID of the affected model
            'old_values' => 'nullable|json', // JSON format for old values
            'new_values' => 'nullable|json', // JSON format for new values
            'ip_address' => 'required|string|max:255', // IP address of the staff member
            'user_agent' => 'required|string|max:255', // User agent (browser info) of the staff
        ]);

        // Create a new audit log record
        AuditLog::create([
            'staff_id' => $request->staff_id,
            'action' => $request->action,
            'auditable_type' => $request->auditable_type,
            'auditable_id' => $request->auditable_id,
            'old_values' => $request->old_values,
            'new_values' => $request->new_values,
            'ip_address' => $request->ip_address,
            'user_agent' => $request->user_agent,
        ]);

        // Redirect back to the audit logs index with a success message
        return redirect()->route('audit.logs.index')->with('success', 'Audit log created successfully.');
    }

    // Optional: You can add a method to edit the log, but it is usually not needed for audit logs
}
