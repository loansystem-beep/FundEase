<?php

namespace App\Http\Controllers;

use App\Models\StaffEmailNotification;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffEmailNotificationController extends Controller
{
    /**
     * Display the list of email notification settings for all staff.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all email notification settings with the associated staff member
        $notifications = StaffEmailNotification::with('staff')->get();
        
        // Pass the notifications to the view
        return view('staff.email_notifications.index', compact('notifications'));
    }

    /**
     * Show the form to create a new email notification setting for a staff member.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Fetch all staff members to populate the dropdown in the create view
        $staffMembers = Staff::all();
        
        // Pass the staff members to the create view
        return view('staff.email_notifications.create', compact('staffMembers'));
    }

    /**
     * Store the email notification settings for a new staff member.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'daily_loans_due' => 'nullable|boolean',
            'daily_loans_expiring' => 'nullable|boolean',
            'daily_loans_past_maturity' => 'nullable|boolean',
            'daily_new_loans_added' => 'nullable|boolean',
            'daily_new_repayments_added' => 'nullable|boolean',
            'weekly_reports' => 'nullable|boolean',
            'notify_repayment_approval' => 'nullable|boolean',
            'notify_savings_approval' => 'nullable|boolean',
            'notify_journal_approval' => 'nullable|boolean',
        ]);

        // Create a new email notification record
        StaffEmailNotification::create([
            'staff_id' => $request->staff_id,
            'daily_loans_due' => $request->has('daily_loans_due'),
            'daily_loans_expiring' => $request->has('daily_loans_expiring'),
            'daily_loans_past_maturity' => $request->has('daily_loans_past_maturity'),
            'daily_new_loans_added' => $request->has('daily_new_loans_added'),
            'daily_new_repayments_added' => $request->has('daily_new_repayments_added'),
            'weekly_reports' => $request->has('weekly_reports'),
            'notify_repayment_approval' => $request->has('notify_repayment_approval'),
            'notify_savings_approval' => $request->has('notify_savings_approval'),
            'notify_journal_approval' => $request->has('notify_journal_approval'),
        ]);

        // Redirect back to the index page with a success message
        return redirect()->route('email.notifications.index')->with('success', 'Email notifications created successfully!');
    }

    /**
     * Show the form to edit email notifications for a specific staff member.
     *
     * @param  int  $staffId
     * @return \Illuminate\View\View
     */
    public function edit($staffId)
    {
        // Fetch the email notification settings for the given staff member
        $notification = StaffEmailNotification::where('staff_id', $staffId)->first();
        
        if (!$notification) {
            // If no notification settings found, create a new one
            $notification = new StaffEmailNotification(['staff_id' => $staffId]);
        }

        // Pass the notification settings to the edit view
        return view('staff.email_notifications.edit', compact('notification'));
    }

    /**
     * Update the email notification settings for a specific staff member.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $staffId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $staffId)
    {
        // Validate the incoming data
        $request->validate([
            'daily_loans_due' => 'nullable|boolean',
            'daily_loans_expiring' => 'nullable|boolean',
            'daily_loans_past_maturity' => 'nullable|boolean',
            'daily_new_loans_added' => 'nullable|boolean',
            'daily_new_repayments_added' => 'nullable|boolean',
            'weekly_reports' => 'nullable|boolean',
            'notify_repayment_approval' => 'nullable|boolean',
            'notify_savings_approval' => 'nullable|boolean',
            'notify_journal_approval' => 'nullable|boolean',
        ]);

        // Fetch the email notification settings for the given staff member
        $notification = StaffEmailNotification::where('staff_id', $staffId)->first();

        // If no settings exist, create a new one
        if (!$notification) {
            $notification = new StaffEmailNotification();
            $notification->staff_id = $staffId;
        }

        // Update the notification settings
        $notification->update([
            'daily_loans_due' => $request->has('daily_loans_due'),
            'daily_loans_expiring' => $request->has('daily_loans_expiring'),
            'daily_loans_past_maturity' => $request->has('daily_loans_past_maturity'),
            'daily_new_loans_added' => $request->has('daily_new_loans_added'),
            'daily_new_repayments_added' => $request->has('daily_new_repayments_added'),
            'weekly_reports' => $request->has('weekly_reports'),
            'notify_repayment_approval' => $request->has('notify_repayment_approval'),
            'notify_savings_approval' => $request->has('notify_savings_approval'),
            'notify_journal_approval' => $request->has('notify_journal_approval'),
        ]);

        // Redirect back with a success message
        return redirect()->route('email.notifications.index')->with('success', 'Notification settings updated successfully!');
    }
}
