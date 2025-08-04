<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\Order;
use App\Models\Setting;
use App\Http\Controllers\AppHelper;
use App\Models\User;
use App\Models\AppUser;
use App\Models\Banner;
use App\Models\Coupon;
use Carbon\Carbon;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (Auth::user()->hasRole('admin')) {
            $timezone = Setting::find(1)->timezone;
            $date = Carbon::now($timezone);
            $events  = Event::with(['category:id,name'])
                ->where([['is_deleted', 0], ['event_status', 'Pending']]);
            $chip = array();
            if ($request->has('type') && $request->type != null) {
                $chip['type'] = $request->type;
                $events = $events->where('type', $request->type);
            }
            if ($request->has('category') && $request->category != null) {
                $chip['category'] = Category::find($request->category)->name;
                $events = $events->where('category_id', $request->category);
            }
            if ($request->has('duration') && $request->duration != null) {
                $chip['date'] = $request->duration;
                if ($request->duration == 'Today') {
                    $temp = Carbon::now($timezone)->format('Y-m-d');
                    $events = $events->whereBetween('start_time', [$temp . ' 00:00:00', $temp . ' 23:59:59']);
                } else if ($request->duration == 'Tomorrow') {
                    $temp = Carbon::tomorrow($timezone)->format('Y-m-d');
                    $events = $events->whereBetween('start_time', [$temp . ' 00:00:00', $temp . ' 23:59:59']);
                } else if ($request->duration == 'ThisWeek') {
                    $now = Carbon::now($timezone);
                    $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i:s');
                    $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i:s');
                    $events = $events->whereBetween('start_time', [$weekStartDate, $weekEndDate]);
                } else if ($request->duration == 'date') {
                    if (isset($request->date)) {
                        $temp = Carbon::parse($request->date)->format('Y-m-d H:i:s');
                        $events = $events->whereBetween('start_time', [$request->date . ' 00:00:00', $request->date . ' 23:59:59']);
                    }
                }
            }
            $events = $events->orderBy('start_time', 'DESC')->get();
        } elseif (Auth::user()->hasRole('Organizer')) {
            $timezone = Setting::find(1)->timezone;
            $date = Carbon::now($timezone);
            $events  = Event::with(['category:id,name'])
                ->where([['status', 1], ['user_id', Auth::user()->id], ['is_deleted', 0], ['event_status', 'Pending']]);
            $chip = array();
            if ($request->has('type') && $request->type != null) {
                $chip['type'] = $request->type;
                $events = $events->where('type', $request->type);
            }
            if ($request->has('category') && $request->category != null) {
                $chip['category'] = Category::find($request->category)->name;
                $events = $events->where('category_id', $request->category);
            }
            if ($request->has('duration') && $request->duration != null) {
                $chip['date'] = $request->duration;
                if ($request->duration == 'Today') {
                    $temp = Carbon::now($timezone)->format('Y-m-d');
                    $events = $events->whereBetween('start_time', [$temp . ' 00:00:00', $temp . ' 23:59:59']);
                } else if ($request->duration == 'Tomorrow') {
                    $temp = Carbon::tomorrow($timezone)->format('Y-m-d');
                    $events = $events->whereBetween('start_time', [$temp . ' 00:00:00', $temp . ' 23:59:59']);
                } else if ($request->duration == 'ThisWeek') {
                    $now = Carbon::now($timezone);
                    $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i:s');
                    $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i:s');
                    $events = $events->whereBetween('start_time', [$weekStartDate, $weekEndDate]);
                } else if ($request->duration == 'date') {
                    if (isset($request->date)) {
                        $temp = Carbon::parse($request->date)->format('Y-m-d H:i:s');
                        $events = $events->whereBetween('start_time', [$request->date . ' 00:00:00', $request->date . ' 23:59:59']);
                    }
                }
            }
            $events = $events->orderBy('start_time', 'DESC')->get();

        }
        return view('admin.event.index', compact('events'));
    }

    public function create()
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category = Category::where('status', 1)->orderBy('id', 'DESC')->get();
        $users = User::role('Organizer')->orderBy('id', 'DESC')->get();
        if (Auth::user()->hasRole('admin')) {
            $scanner = User::role('scanner')->orderBy('id', 'DESC')->get();
        } else if (Auth::user()->hasRole('Organizer')) {
            $scanner = User::role('scanner')->where('org_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        }
        return view('admin.event.create-wizard', compact('category', 'users', 'scanner'));
    }

    public function store(Request $request)
    {
         $request->validate([
            'name' => 'bail|required',
            'image' => 'bail|required|image|mimes:jpeg,png,jpg,gif|max:3048',
            'start_time' => 'bail|required|date',
            'end_time' => 'bail|required|date|after:start_time',
            'category_id' => 'bail|required',
            'type' => 'bail|required',
            'address' => 'bail|required',
            'lat_long' => 'bail|nullable',
            'status' => 'bail|required',
            'people' => 'bail|required',
        ]);
        $data = $request->all();
        
        // No need to process datetime-local inputs - they come in the correct format
        
        // Handle location coordinates
        if ($request->lat_long) {
            $coords = explode(',', $request->lat_long);
            if (count($coords) >= 2) {
                $data['lat'] = trim($coords[0]);
                $data['lang'] = trim($coords[1]);
            }
        }
        
        // Set default values for wizard
        $data['security'] = 1;
        $data['description'] = $request->description ?? 'Event created via wizard';
        $data['scanner_id'] = $request->scanner_id ? implode(',', $request->scanner_id) : '';
        if ($request->hasFile('image')) {

            $data['image'] = (new AppHelper)->saveImage($request);
        }
        if (!Auth::user()->hasRole('admin')) {
            $data['user_id'] = Auth::user()->id;
        }
        $event = Event::create($data);
        
        // Automatically create tickets for the event
        $this->createEventTickets($event, $request);
        
        // Return JSON response for AJAX handling
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'event_id' => $event->id,
                'event' => $event,
                'message' => __('Event has been created successfully.')
            ]);
        }
        
        return redirect()->route('events.index')->withStatus(__('Event has added successfully.'));
    }
    
    /**
     * Automatically create tickets for the event based on wizard form data
     */
    private function createEventTickets($event, $request)
    {
        // Set ticket sale period: tickets are available from now until the event starts
        $now = now();
        $ticketSaleEnd = \Carbon\Carbon::parse($event->start_time)->subHours(1); // Stop selling 1 hour before event
        
        // If event is very soon, allow sales until event start time
        if ($ticketSaleEnd <= $now) {
            $ticketSaleEnd = \Carbon\Carbon::parse($event->start_time);
        }
        
        $ticketData = [
            'event_id' => $event->id,
            'name' => $event->name . ' - General Admission',
            'quantity' => $request->quantity ?? 100,
            'price' => $request->type === 'free' ? 0 : ($request->price ?? 0),
            'start_time' => $now, // Tickets available immediately
            'end_time' => $ticketSaleEnd, // Stop selling before event starts
            'type' => $request->type ?? 'paid',
            'ticket_per_order' => 10,
            'ticket_number' => chr(rand(65, 90)) . chr(rand(65, 90)) . '-' . rand(999, 10000),
            'user_id' => $event->user_id,
            'status' => 1,
            'is_deleted' => 0,
        ];
        
        Ticket::create($ticketData);
    }

    public function show($event)
    {
        $event = Event::with(['category', 'organization'])->find($event);
        $event->ticket = Ticket::where([['event_id', $event->id], ['is_deleted', 0]])->orderBy('id', 'DESC')->get();
        (new AppHelper)->eventStatusChange();
        $event->sales = Order::with(['customer:id,name', 'ticket:id,name'])->where('event_id', $event->id)->orderBy('id', 'DESC')->get();
        
        // Fetch event invites for this event
        $event->invites = \DB::table('event_invites')
            ->where('event_id', $event->id)
            ->orderBy('created_at', 'DESC')
            ->get();
        
        // Calculate scan statistics
        $scanStats = $this->calculateScanStatistics($event->id);
        $event->scanStats = $scanStats;
        
        foreach ($event->ticket as $value) {
            $value->used_ticket = Order::where('ticket_id', $value->id)->sum('quantity');
        }
        return view('admin.event.view', compact('event'));
    }

    /**
     * Calculate comprehensive scan statistics for an event
     */
    private function calculateScanStatistics($eventId)
    {
        // Get all orders for this event
        $orders = \DB::table('orders')
            ->where('event_id', $eventId)
            ->where('order_status', 'Complete')
            ->get();
        
        if ($orders->isEmpty()) {
            return [
                'total_tickets' => 0,
                'scanned_tickets' => 0,
                'partially_scanned_tickets' => 0,
                'remaining_tickets' => 0,
                'total_scans' => 0,
                'scan_percentage' => 0,
                'recent_scans' => collect([]),
                'scan_by_ticket_type' => []
            ];
        }
        
        $orderIds = $orders->pluck('id')->toArray();
        
        // Get all ticket children for these orders
        $ticketChildren = \DB::table('order_child')
            ->whereIn('order_id', $orderIds)
            ->get();
        
        // Calculate basic statistics with multi-scan support
        $totalTickets = $ticketChildren->count();
        $totalScans = $orders->sum('checkins_count') ?: 0; // Total scans performed
        $scannedTickets = $ticketChildren->where('status', 1)->count(); // Fully used tickets
        $partiallyScannedTickets = $orders->where('checkins_count', '>', 0)->count() - $scannedTickets; // Partially scanned
        $remainingTickets = $totalTickets - $scannedTickets - $partiallyScannedTickets;
        $scanPercentage = $totalTickets > 0 ? round((($scannedTickets + $partiallyScannedTickets) / $totalTickets) * 100, 1) : 0;
        
        // Get recent scans (last 10) - now includes multi-scan info
        $recentScans = \DB::table('orders')
            ->join('tickets', 'orders.ticket_id', '=', 'tickets.id')
            ->join('app_user', 'orders.customer_id', '=', 'app_user.id')
            ->whereIn('orders.id', $orderIds)
            ->where('orders.checkins_count', '>', 0)
            ->select(
                'orders.order_id as ticket_number',
                'orders.updated_at as scanned_at',
                'tickets.name as ticket_name',
                'app_user.name as customer_name',
                'app_user.email as customer_email',
                'orders.checkins_count as current_scans',
                'tickets.maximum_checkins as max_scans'
            )
            ->orderBy('orders.updated_at', 'DESC')
            ->limit(10)
            ->get();
        
        // Get scan statistics by ticket type with multi-scan support
        $scanByTicketType = \DB::table('orders')
            ->join('tickets', 'orders.ticket_id', '=', 'tickets.id')
            ->whereIn('orders.id', $orderIds)
            ->select(
                'tickets.name as ticket_name',
                'tickets.id as ticket_id',
                'tickets.maximum_checkins as max_scans_per_ticket',
                \DB::raw('COUNT(*) as total_tickets'),
                \DB::raw('SUM(orders.checkins_count) as total_scans'),
                \DB::raw('SUM(CASE WHEN orders.checkins_count > 0 THEN 1 ELSE 0 END) as tickets_with_scans'),
                \DB::raw('COUNT(*) - SUM(CASE WHEN orders.checkins_count > 0 THEN 1 ELSE 0 END) as unscanned_tickets')
            )
            ->groupBy('tickets.id', 'tickets.name', 'tickets.maximum_checkins')
            ->get()
            ->map(function ($item) {
                $item->scan_percentage = $item->total_tickets > 0 ? 
                    round(($item->tickets_with_scans / $item->total_tickets) * 100, 1) : 0;
                $item->avg_scans_per_ticket = $item->tickets_with_scans > 0 ? 
                    round($item->total_scans / $item->tickets_with_scans, 1) : 0;
                return $item;
            });
        
        return [
            'total_tickets' => $totalTickets,
            'scanned_tickets' => $scannedTickets,
            'partially_scanned_tickets' => $partiallyScannedTickets,
            'remaining_tickets' => $remainingTickets,
            'total_scans' => $totalScans,
            'scan_percentage' => $scanPercentage,
            'recent_scans' => $recentScans,
            'scan_by_ticket_type' => $scanByTicketType
        ];
    }

    public function edit(Event $event)
    {
        abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category =  Category::where('status', 1)->orderBy('id', 'DESC')->get();
        $users = User::role('Organizer')->orderBy('id', 'DESC')->get();
        if (Auth::user()->hasRole('admin')) {
            $scanner = User::role('scanner')->orderBy('id', 'DESC')->get();
        } else if (Auth::user()->hasRole('Organizer')) {
            $scanner = User::role('scanner')->where('org_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        }
        return view('admin.event.edit', compact('event', 'category', 'users', 'scanner'));
    }

    public function update(Request $request, Event $event)
    {

        $request->validate([
            'name' => 'bail|required',
            'start_time' => 'bail|required',
            'end_time' => 'bail|required',
            'category_id' => 'bail|required',
            'type' => 'bail|required',
            'address' => 'bail|required_if:type,offline',
            'lat' => 'bail|required_if:type,offline',
            'lang' => 'bail|required_if:type,offline',
            'status' => 'bail|required',
            'url' => 'bail|required_if:type,online',
            'description' => 'bail|required',
            'scanner_id' => 'bail|required_if:type,offline',
            'people' => 'bail|required',
        ]);
        $data = $request->all();
        if($request->type == 'offline'){
            $data['scanner_id'] = implode(',', $request->scanner_id);
        }
        if ($request->hasFile('image')) {
            (new AppHelper)->deleteFile($event->image);
            $data['image'] = (new AppHelper)->saveImage($request);
        }
        $event = Event::find($event->id)->update($data);
        return redirect()->route('events.index')->withStatus(__('Event has updated successfully.'));
    }

    public function destroy(Event $event)
    {
        try {
            Event::find($event->id)->update(['is_deleted' => 1, 'event_status' => 'Deleted']);
            $ticket = Ticket::where('event_id', $event->id)->update(['is_deleted' => 1]);
            $banner = Banner::where('event_id', $event->id)->update(['status' => 0]);
            $coupon = Coupon::where('event_id', $event->id)->update(['status' => 0]);
            return true;
        } catch (Throwable $th) {
            return response('Data is Connected with other Data', 400);
        }
    }

    public function getMonthEvent(Request $request)
    {
        (new AppHelper)->eventStatusChange();
        $day = Carbon::parse($request->year . '-' . $request->month . '-01')->daysInMonth;
        if (Auth::user()->hasRole('Organizer')) {
            $data = Event::whereBetween('start_time', [$request->year . "-" . $request->month . "-01 12:00",  $request->year . "-" . $request->month . "-" . $day . "  23:59"])
                ->where([['status', 1], ['is_deleted', 0], ['user_id', Auth::user()->id]])
                ->orderBy('id', 'DESC')
                ->get();
        }
        if (Auth::user()->hasRole('admin')) {
            $data = Event::whereBetween('start_time', [$request->year . "-" . $request->month . "-01 12:00",  $request->year . "-" . $request->month . "-" . $day . " 23:59"])
                ->where([['status', 1], ['is_deleted', 0]])->orderBy('id', 'DESC')->get();
        }
        foreach ($data as $value) {
            $value->tickets = Ticket::where([['event_id', $value->id], ['is_deleted', 0]])->sum('quantity');
            $value->sold_ticket = Order::where('event_id', $value->id)->sum('quantity');
            $value->day = $value->start_time->format('D');
            $value->date = $value->start_time->format('d');
            $value->average = $value->tickets == 0 ? 0 : $value->sold_ticket * 100 / $value->tickets;
        }
        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function eventGallery($id)
    {
        $data  = Event::find($id);
        return view('admin.event.gallery', compact('data'));
    }

    public function addEventGallery(Request $request)
    {
        $event = array_filter(explode(',', Event::find($request->id)->gallery));
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $name = uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            array_push($event, $name);
            Event::find($request->id)->update(['gallery' => implode(',', $event)]);
        }
        return true;
    }

    public function removeEventImage($image, $id)
    {

        $gallery = array_filter(explode(',', Event::find($id)->gallery));
        if (count(array_keys($gallery, $image)) > 0) {
            if (($key = array_search($image, $gallery)) !== false) {
                unset($gallery[$key]);
            }
        }
        $aa = implode(',', $gallery);
        $data = Event::find($id);
        $data->gallery = $aa;
        $data->update();
        return redirect()->back();
    }

    /**
     * Send event invite to guest
     */
    public function sendInvite(Request $request, $id)
    {
        try {
            // Validate the request
            $request->validate([
                'guest_name' => 'required|string|max:255',
                'guest_email' => 'required|email|max:255',
                'invite_type' => 'required|string|in:speaker,vip,sponsor,media,staff,general',
                'invite_message' => 'nullable|string|max:1000'
            ]);

            // Find the event
            $event = Event::findOrFail($id);

            // Generate unique invite token
            $inviteToken = bin2hex(random_bytes(32));

            // Create the invite record
            $invite = \DB::table('event_invites')->insertGetId([
                'event_id' => $event->id,
                'guest_name' => $request->guest_name,
                'guest_email' => $request->guest_email,
                'invite_type' => $request->invite_type,
                'invite_message' => $request->invite_message,
                'invite_token' => $inviteToken,
                'status' => 'pending',
                'sent_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Get the created invite data
            $inviteData = \DB::table('event_invites')->where('id', $invite)->first();

            // Generate invite URL
            $inviteUrl = route('invite.show', $inviteToken);

            // Get application settings
            $setting = \App\Models\Setting::select('sender_email', 'app_name')->first();

            // Send email notification to guest
            try {
                \Mail::to($request->guest_email)->send(new \App\Mail\EventInvite($inviteData, $event, $setting, $inviteUrl));
                
                \Log::info('Event invite email sent successfully', [
                    'event_id' => $event->id,
                    'guest_email' => $request->guest_email,
                    'invite_token' => $inviteToken,
                    'sender_email' => $setting->sender_email
                ]);
                
            } catch (\Exception $emailError) {
                \Log::error('Failed to send invite email: ' . $emailError->getMessage(), [
                    'event_id' => $event->id,
                    'guest_email' => $request->guest_email,
                    'invite_token' => $inviteToken
                ]);
                
                // Still return success since the invite was created, but note email failure
                return response()->json([
                    'success' => true,
                    'message' => 'Invite created successfully, but email delivery failed. Please check email configuration.',
                    'invite_token' => $inviteToken,
                    'email_sent' => false
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Invite sent successfully to ' . $request->guest_name . '. They will receive an email with the invitation details.',
                'invite_token' => $inviteToken,
                'email_sent' => true
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Please check your input and try again.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Event invite error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send invite. Please try again.'
            ], 500);
        }
    }

    /**
     * Show invite page to guest
     */
    public function showInvite($token)
    {
        try {
            // Find the invite by token
            $invite = \DB::table('event_invites')
                ->where('invite_token', $token)
                ->first();

            if (!$invite) {
                abort(404, 'Invite not found');
            }

            // Get the event details
            $event = Event::findOrFail($invite->event_id);

            return view('frontend.invite', compact('invite', 'event'));

        } catch (\Exception $e) {
            \Log::error('Show invite error: ' . $e->getMessage());
            abort(404, 'Invite not found');
        }
    }

    /**
     * Handle guest response to invite
     */
    public function respondToInvite(Request $request, $token)
    {
        try {
            // Validate the response
            $request->validate([
                'response' => 'required|string|in:confirmed,rejected'
            ]);

            // Find the invite by token
            $invite = \DB::table('event_invites')
                ->where('invite_token', $token)
                ->first();

            if (!$invite) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invite not found'
                ], 404);
            }

            // Check if already responded
            if ($invite->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already responded to this invite'
                ], 400);
            }

            // Update the invite status
            \DB::table('event_invites')
                ->where('invite_token', $token)
                ->update([
                    'status' => $request->response,
                    'responded_at' => now(),
                    'updated_at' => now()
                ]);

            $responseMessage = $request->response === 'confirmed' 
                ? 'Thank you for confirming your attendance!' 
                : 'Thank you for your response. We understand you cannot attend.';

            return response()->json([
                'success' => true,
                'message' => $responseMessage,
                'status' => $request->response
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid response',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Invite response error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process response. Please try again.'
            ], 500);
        }
    }
}
