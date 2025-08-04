@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Event Detail '),
            'headerData' => __('Event') ,
            'url' => 'events' ,
        ])

      <div class="section-body">
         <!-- Enhanced Event Preview Section -->
         <div class="row mb-4">
             <div class="col-12">
                 <div class="card border-0 shadow-sm">
                     <div class="card-body p-0">
                         <!-- Event Header with Success Badge -->
                         <div class="bg-gradient-primary text-white p-4 rounded-top">
                             <div class="row align-items-center">
                                 <div class="col-md-8">
                                     <h2 class="mb-2 text-white">
                                         <i class="fas fa-calendar-check mr-2"></i>
                                         {{$event->name}}
                                     </h2>
                                     <p class="mb-0 text-white-50">
                                         <i class="fas fa-check-circle mr-1"></i>
                                         Event is live and ready for bookings
                                     </p>
                                 </div>
                                 <div class="col-md-4 text-right">
                                     <button type="button" class="btn btn-success btn-lg mr-2" data-toggle="modal" data-target="#sendInviteModal">
                                         <i class="fas fa-envelope mr-2"></i>{{__('Send Invite')}}
                                     </button>
                                     <button type="button" class="btn btn-light btn-lg">
                                         <a class="text-primary text-decoration-none" href="{{url($event->id.'/'.preg_replace('/\s+/', '-', $event->name).'/tickets')}}">
                                             <i class="fas fa-ticket-alt mr-2"></i>{{__('Manage Tickets')}}
                                         </a>
                                     </button>
                                 </div>
                             </div>
                         </div>
                         
                         <!-- Enhanced Event Details -->
                         <div class="p-4">
                             <div class="row">
                                 <!-- Event Details Column -->
                                 <div class="col-lg-8">
                                     <div class="event-card border rounded p-4 bg-light mb-4">
                                         <div class="row">
                                             <div class="col-md-4">
                                                 <div class="event-image">
                                                     <img src="{{url('images/upload/'.$event->image)}}" alt="{{$event->name}}" class="img-fluid rounded shadow" style="width: 100%; height: 200px; object-fit: cover;">
                                                 </div>
                                             </div>
                                             <div class="col-md-8">
                                                 <div class="event-details">
                                                     <h4 class="mb-3 text-primary">{{$event->name}}</h4>
                                                     <div class="event-info">
                                                         <div class="info-item mb-2 d-flex align-items-center">
                                                             <i class="fas fa-tag text-success mr-2"></i>
                                                             <strong class="mr-2">Category:</strong> 
                                                             <span class="badge badge-primary">{{$event->category->name ?? 'General'}}</span>
                                                         </div>
                                                         <div class="info-item mb-2 d-flex align-items-center">
                                                             <i class="fas fa-credit-card text-success mr-2"></i>
                                                             <strong class="mr-2">Type:</strong> 
                                                             <span class="badge badge-info">{{ucfirst($event->type)}}</span>
                                                         </div>
                                                         <div class="info-item mb-2 d-flex align-items-center">
                                                             <i class="fas fa-map-marker-alt text-success mr-2"></i>
                                                             <strong class="mr-2">Location:</strong> 
                                                             <span>{{$event->type == 'offline' ? $event->address : 'Online Event'}}</span>
                                                         </div>
                                                         <div class="info-item mb-2 d-flex align-items-center">
                                                             <i class="fas fa-calendar text-success mr-2"></i>
                                                             <strong class="mr-2">Date:</strong> 
                                                             <span>{{$event->start_time->format('d F Y')}}</span>
                                                         </div>
                                                         <div class="info-item mb-2 d-flex align-items-center">
                                                             <i class="fas fa-clock text-success mr-2"></i>
                                                             <strong class="mr-2">Time:</strong> 
                                                             <span>{{$event->start_time->format('h:i A')}} - {{$event->end_time->format('h:i A')}}</span>
                                                         </div>
                                                         <div class="info-item mb-2 d-flex align-items-center">
                                                             <i class="fas fa-users text-success mr-2"></i>
                                                             <strong class="mr-2">Capacity:</strong> 
                                                             <span class="badge badge-warning">{{$event->people}} people</span>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         
                                         <!-- Event Description -->
                                         @if($event->description)
                                         <div class="mt-4 pt-3 border-top">
                                             <h6 class="text-muted mb-2">
                                                 <i class="fas fa-info-circle mr-1"></i>
                                                 Event Description
                                             </h6>
                                             <div class="event-description">
                                                 {!! $event->description !!}
                                             </div>
                                         </div>
                                         @endif
                                     </div>
                                 </div>
                                 
                                 <!-- QR Code & Sharing Column -->
                                 <div class="col-lg-4">
                                     <div class="qr-section">
                                         <div class="qr-card border rounded p-4 bg-white shadow-sm mb-4">
                                             <h5 class="mb-3 text-primary text-center">
                                                 <i class="fas fa-qrcode mr-2"></i>
                                                 Event QR Code
                                             </h5>
                                             <div id="qr-code-container" class="mb-3 text-center">
                                                 <div id="qr-placeholder" class="p-4 bg-light rounded">
                                                     <i class="fas fa-qrcode fa-3x text-muted"></i>
                                                     <p class="text-muted mt-2 mb-0">Loading QR Code...</p>
                                                 </div>
                                                 <canvas id="qr-canvas" style="display: none;"></canvas>
                                             </div>
                                             <p class="small text-muted text-center mb-3">Scan to view event details</p>
                                             
                                             <!-- QR Actions -->
                                             <div class="text-center">
                                                 <button type="button" class="btn btn-outline-primary btn-sm mr-2" onclick="downloadEventQR()">
                                                     <i class="fas fa-download mr-1"></i> Download
                                                 </button>
                                                 <button type="button" class="btn btn-outline-secondary btn-sm" onclick="copyEventLink()">
                                                     <i class="fas fa-link mr-1"></i> Copy Link
                                                 </button>
                                             </div>
                                         </div>
                                         
                                         <!-- Sharing Section -->
                                         <div class="sharing-card border rounded p-4 bg-white shadow-sm">
                                             <h6 class="mb-3 text-center">
                                                 <i class="fas fa-share-alt mr-2"></i>
                                                 Share Event
                                             </h6>
                                             <div class="d-flex justify-content-center flex-wrap">
                                                 <button type="button" class="btn btn-facebook btn-sm mr-2 mb-2" onclick="shareEventOnFacebook()">
                                                     <i class="fab fa-facebook-f mr-1"></i> Facebook
                                                 </button>
                                                 <button type="button" class="btn btn-info btn-sm mr-2 mb-2" onclick="shareEventOnTwitter()">
                                                     <i class="fab fa-twitter mr-1"></i> Twitter
                                                 </button>
                                                 <button type="button" class="btn btn-success btn-sm mb-2" onclick="shareEventOnWhatsApp()">
                                                     <i class="fab fa-whatsapp mr-1"></i> WhatsApp
                                                 </button>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         
         <!-- Image Gallery Section -->
         @if($event->gallery && trim($event->gallery) !== '')
         <div class="row mb-4">
             <div class="col-12">
                 <div class="card border-0 shadow-sm">
                     <div class="card-header bg-light">
                         <h5 class="mb-0 text-primary">
                             <i class="fas fa-images mr-2"></i>
                             Event Gallery
                         </h5>
                     </div>
                     <div class="card-body">
                         <div class="row" id="gallery-container">
                             @foreach(array_filter(explode(',', $event->gallery)) as $index => $image)
                                 @if(trim($image) !== '')
                                 <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                     <div class="gallery-item position-relative">
                                         <div class="gallery-image-wrapper">
                                             <img src="{{url('images/upload/'.$image)}}" alt="Event Gallery Image {{$index + 1}}" 
                                                  class="img-fluid rounded shadow gallery-thumbnail"
                                                  data-toggle="modal" 
                                                  data-target="#galleryModal" 
                                                  data-image="{{url('images/upload/'.$image)}}"
                                                  data-index="{{$index}}"
                                                  style="width: 100%; height: 200px; object-fit: cover; cursor: pointer; transition: all 0.3s ease;">
                                             <div class="gallery-overlay">
                                                 <div class="gallery-overlay-content">
                                                     <i class="fas fa-search-plus fa-2x text-white"></i>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 @endif
                             @endforeach
                         </div>
                         
                         @if(count(array_filter(explode(',', $event->gallery))) === 0)
                         <div class="text-center py-5">
                             <div class="mb-3">
                                 <i class="fas fa-images fa-3x text-muted"></i>
                             </div>
                             <h6 class="text-muted mb-3">No additional images available</h6>
                             <p class="text-muted">Additional event photos will appear here when uploaded.</p>
                         </div>
                         @endif
                     </div>
                 </div>
             </div>
         </div>
         @endif
         
         <!-- Ticket Information Section -->
         <div class="row mb-4">
             <div class="col-12">
                 <div class="card border-0 shadow-sm">
                     <div class="card-header bg-light">
                         <h5 class="mb-0 text-primary">
                             <i class="fas fa-ticket-alt mr-2"></i>
                             Event Tickets
                         </h5>
                     </div>
                     <div class="card-body">
                         <div class="row">
                             @if(count($event->ticket)>0)
                                 @foreach ($event->ticket as $item)
                                     <div class="col-lg-4 col-md-6 mb-3">
                                         <div class="card border rounded shadow-sm h-100">
                                             <div class="card-body text-center">
                                                 <div class="ticket-icon mb-3">
                                                     <i class="fas fa-ticket-alt fa-2x text-primary"></i>
                                                 </div>
                                                 <h6 class="card-title text-dark mb-2">{{$item->name}}</h6>
                                                 <div class="price-badge mb-3">
                                                     <span class="badge badge-success badge-lg">{{$currency}}{{$item->price}}</span>
                                                 </div>
                                                 <div class="ticket-stats mb-3">
                                                     <div class="row text-center">
                                                         <div class="col-6">
                                                             <small class="text-muted d-block">Sold</small>
                                                             <strong class="text-primary">{{$item->used_ticket}}</strong>
                                                         </div>
                                                         <div class="col-6">
                                                             <small class="text-muted d-block">Total</small>
                                                             <strong class="text-dark">{{$item->quantity}}</strong>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="progress mb-3" style="height: 8px;">
                                                     <div class="progress-bar bg-primary" role="progressbar" 
                                                          style="width: {{$item->quantity > 0 ? ($item->used_ticket / $item->quantity) * 100 : 0}}%" 
                                                          aria-valuenow="{{$item->used_ticket}}" 
                                                          aria-valuemin="0" 
                                                          aria-valuemax="{{$item->quantity}}">
                                                     </div>
                                                 </div>
                                                 <div class="sales-end-info">
                                                     <small class="text-muted d-block mb-1">Sales end on</small>
                                                     <small class="text-dark font-weight-bold">
                                                         {{$item->start_time->format('M d, Y')}} at {{$item->end_time->format('h:i A')}}
                                                     </small>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 @endforeach
                             @else
                                 <div class="col-12">
                                     <div class="text-center py-5">
                                         <div class="mb-3">
                                             <i class="fas fa-ticket-alt fa-3x text-muted"></i>
                                         </div>
                                         <h6 class="text-muted mb-3">No tickets created yet</h6>
                                         <a href="{{url($event->id.'/ticket/create')}}" class="btn btn-primary">
                                             <i class="fas fa-plus mr-2"></i>Create First Ticket
                                         </a>
                                     </div>
                                 </div>
                             @endif
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         
         <!-- Ticket Scan Statistics Section -->
         <div class="row mb-4">
             <div class="col-12">
                 <div class="card border-0 shadow-sm">
                     <div class="card-header bg-light d-flex justify-content-between align-items-center">
                         <h5 class="mb-0 text-primary">
                             <i class="fas fa-chart-bar mr-2"></i>
                             Ticket Scan Statistics
                         </h5>
                         <a href="{{ url('ticket-scanner') }}" class="btn btn-primary btn-sm">
                             <i class="fas fa-qrcode mr-2"></i>Open Scanner
                         </a>
                     </div>
                     <div class="card-body">
                         @if($event->scanStats['total_tickets'] > 0)
                             <!-- Overall Statistics Cards -->
                             <div class="row mb-4">
                                 <div class="col-lg-3 col-md-6 mb-3">
                                     <div class="card bg-primary text-white h-100">
                                         <div class="card-body text-center">
                                             <div class="mb-2">
                                                 <i class="fas fa-ticket-alt fa-2x"></i>
                                             </div>
                                             <h4 class="mb-1">{{ $event->scanStats['total_tickets'] }}</h4>
                                             <small>Total Tickets</small>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-lg-3 col-md-6 mb-3">
                                     <div class="card bg-success text-white h-100">
                                         <div class="card-body text-center">
                                             <div class="mb-2">
                                                 <i class="fas fa-check-circle fa-2x"></i>
                                             </div>
                                             <h4 class="mb-1">{{ $event->scanStats['scanned_tickets'] }}</h4>
                                             <small>Fully Used</small>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-lg-3 col-md-6 mb-3">
                                     <div class="card bg-warning text-white h-100">
                                         <div class="card-body text-center">
                                             <div class="mb-2">
                                                 <i class="fas fa-clock fa-2x"></i>
                                             </div>
                                             <h4 class="mb-1">{{ $event->scanStats['remaining_tickets'] }}</h4>
                                             <small>Unused</small>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-lg-3 col-md-6 mb-3">
                                     <div class="card bg-info text-white h-100">
                                         <div class="card-body text-center">
                                             <div class="mb-2">
                                                 <i class="fas fa-chart-line fa-2x"></i>
                                             </div>
                                             <h4 class="mb-1">{{ $event->scanStats['total_scans'] ?? 0 }}</h4>
                                             <small>Total Scans</small>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <!-- Progress Bar -->
                             <div class="row mb-4">
                                 <div class="col-12">
                                     <div class="card border">
                                         <div class="card-body">
                                             <div class="d-flex justify-content-between align-items-center mb-2">
                                                 <h6 class="mb-0">Overall Scan Progress</h6>
                                                 <span class="badge badge-primary">{{ $event->scanStats['scan_percentage'] }}%</span>
                                             </div>
                                             <div class="progress" style="height: 20px;">
                                                 <div class="progress-bar bg-success" role="progressbar" 
                                                      style="width: {{ $event->scanStats['scan_percentage'] }}%" 
                                                      aria-valuenow="{{ $event->scanStats['scan_percentage'] }}" 
                                                      aria-valuemin="0" 
                                                      aria-valuemax="100">
                                                     {{ $event->scanStats['scanned_tickets'] }}/{{ $event->scanStats['total_tickets'] }}
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <!-- Scan Statistics by Ticket Type -->
                             @if(count($event->scanStats['scan_by_ticket_type']) > 0)
                             <div class="row mb-4">
                                 <div class="col-12">
                                     <h6 class="mb-3">
                                         <i class="fas fa-list mr-2"></i>
                                         Scan Statistics by Ticket Type
                                     </h6>
                                     <div class="table-responsive">
                                         <table class="table table-hover">
                                             <thead class="thead-light">
                                                 <tr>
                                                     <th>Ticket Type</th>
                                                     <th class="text-center">Total Tickets</th>
                                                     <th class="text-center">Tickets Used</th>
                                                     <th class="text-center">Total Scans</th>
                                                     <th class="text-center">Avg Scans</th>
                                                     <th class="text-center">Max Scans</th>
                                                     <th class="text-center">Progress</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 @foreach($event->scanStats['scan_by_ticket_type'] as $ticketStat)
                                                 <tr>
                                                     <td>
                                                         <i class="fas fa-ticket-alt text-primary mr-2"></i>
                                                         {{ $ticketStat->ticket_name }}
                                                     </td>
                                                     <td class="text-center">
                                                         <span class="badge badge-secondary">{{ $ticketStat->total_tickets }}</span>
                                                     </td>
                                                     <td class="text-center">
                                                         <span class="badge badge-success">{{ $ticketStat->tickets_with_scans ?? 0 }}</span>
                                                     </td>
                                                     <td class="text-center">
                                                         <span class="badge badge-info">{{ $ticketStat->total_scans ?? 0 }}</span>
                                                     </td>
                                                     <td class="text-center">
                                                         <span class="badge badge-primary">{{ $ticketStat->avg_scans_per_ticket ?? 0 }}</span>
                                                     </td>
                                                     <td class="text-center">
                                                         <span class="badge badge-dark">
                                                             @if($ticketStat->max_scans_per_ticket && $ticketStat->max_scans_per_ticket > 0)
                                                                 {{ $ticketStat->max_scans_per_ticket }}
                                                             @else
                                                                 ∞
                                                             @endif
                                                         </span>
                                                     </td>
                                                     <td class="text-center">
                                                         <span class="badge badge-warning">{{ $ticketStat->unscanned_tickets ?? 0 }}</span>
                                                     </td>
                                                     <td class="text-center">
                                                         <div class="progress" style="width: 100px; height: 20px;">
                                                             <div class="progress-bar bg-success" role="progressbar" 
                                                                  style="width: {{ $ticketStat->scan_percentage }}%" 
                                                                  title="{{ $ticketStat->scan_percentage }}%">
                                                             </div>
                                                         </div>
                                                         <small class="text-muted">{{ $ticketStat->scan_percentage }}%</small>
                                                     </td>
                                                 </tr>
                                                 @endforeach
                                             </tbody>
                                         </table>
                                     </div>
                                 </div>
                             </div>
                             @endif

                             <!-- Recent Scans -->
                             @if(count($event->scanStats['recent_scans']) > 0)
                             <div class="row">
                                 <div class="col-12">
                                     <h6 class="mb-3">
                                         <i class="fas fa-history mr-2"></i>
                                         Recent Scans
                                     </h6>
                                     <div class="table-responsive">
                                         <table class="table table-sm">
                                             <thead class="thead-light">
                                                 <tr>
                                                     <th>Ticket Code</th>
                                                     <th>Ticket Type</th>
                                                     <th>Customer</th>
                                                     <th>Scan Count</th>
                                                     <th>Last Scanned</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 @foreach($event->scanStats['recent_scans'] as $scan)
                                                 <tr>
                                                     <td>
                                                         <code class="bg-light px-2 py-1 rounded">{{ $scan->ticket_number }}</code>
                                                     </td>
                                                     <td>{{ $scan->ticket_name }}</td>
                                                     <td>
                                                         <div>
                                                             <strong>{{ $scan->customer_name }}</strong>
                                                             <br><small class="text-muted">{{ $scan->customer_email }}</small>
                                                         </div>
                                                     </td>
                                                     <td>
                                                         <span class="badge badge-primary">
                                                             {{ $scan->current_scans ?? 0 }}
                                                             @if($scan->max_scans && $scan->max_scans > 0)
                                                                 / {{ $scan->max_scans }}
                                                             @else
                                                                 / ∞
                                                             @endif
                                                         </span>
                                                     </td>
                                                     <td>
                                                         <small>{{ \Carbon\Carbon::parse($scan->scanned_at)->format('M j, Y g:i A') }}</small>
                                                     </td>
                                                 </tr>
                                                 @endforeach
                                             </tbody>
                                         </table>
                                     </div>
                                 </div>
                             </div>
                             @endif

                         @else
                             <!-- No Tickets Sold Yet -->
                             <div class="text-center py-5">
                                 <div class="mb-3">
                                     <i class="fas fa-chart-bar fa-3x text-muted"></i>
                                 </div>
                                 <h6 class="text-muted mb-3">No tickets sold yet</h6>
                                 <p class="text-muted">Scan statistics will appear here once tickets are purchased and scanned.</p>
                                 <a href="{{ url('ticket-scanner') }}" class="btn btn-outline-primary">
                                     <i class="fas fa-qrcode mr-2"></i>Open Ticket Scanner
                                 </a>
                             </div>
                         @endif
                     </div>
                 </div>
             </div>
         </div>
         
         <!-- Event Invites Section -->
          <div class="row mb-4">
              <div class="col-12">
                  <div class="card border-0 shadow-sm">
                      <div class="card-header bg-light">
                          <h5 class="mb-0 text-primary">
                              <i class="fas fa-envelope mr-2"></i>
                              Event Invites
                              @if(count($event->invites) > 0)
                                  <span class="badge badge-secondary ml-2">{{ count($event->invites) }}</span>
                              @endif
                          </h5>
                      </div>
                      <div class="card-body">
                          @if(count($event->invites) > 0)
                              <div class="table-responsive">
                                  <table class="table table-hover">
                                      <thead class="thead-light">
                                          <tr>
                                              <th>Guest Name</th>
                                              <th>Email</th>
                                              <th>Invite Type</th>
                                              <th>Status</th>
                                              <th>Sent Date</th>
                                              <th>Response Date</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach($event->invites as $invite)
                                              <tr>
                                                  <td>
                                                      <div class="d-flex align-items-center">
                                                          <div class="invite-avatar mr-3">
                                                              <div class="avatar-circle bg-primary text-white">
                                                                  {{ strtoupper(substr($invite->guest_name, 0, 1)) }}
                                                              </div>
                                                          </div>
                                                          <div>
                                                              <strong>{{ $invite->guest_name }}</strong>
                                                              @if($invite->invite_message)
                                                                  <br><small class="text-muted">{{ Str::limit($invite->invite_message, 50) }}</small>
                                                              @endif
                                                          </div>
                                                      </div>
                                                  </td>
                                                  <td>
                                                      <span class="text-muted">{{ $invite->guest_email }}</span>
                                                  </td>
                                                  <td>
                                                      <span class="badge badge-info">{{ ucfirst($invite->invite_type) }}</span>
                                                  </td>
                                                  <td>
                                                      @if($invite->status === 'confirmed')
                                                          <span class="badge badge-success">
                                                              <i class="fas fa-check mr-1"></i>Confirmed
                                                          </span>
                                                      @elseif($invite->status === 'rejected')
                                                          <span class="badge badge-danger">
                                                              <i class="fas fa-times mr-1"></i>Declined
                                                          </span>
                                                      @else
                                                          <span class="badge badge-warning">
                                                              <i class="fas fa-clock mr-1"></i>Pending
                                                          </span>
                                                      @endif
                                                  </td>
                                                  <td>
                                                      <small class="text-muted">
                                                          {{ \Carbon\Carbon::parse($invite->created_at)->format('M d, Y') }}
                                                          <br>{{ \Carbon\Carbon::parse($invite->created_at)->format('h:i A') }}
                                                      </small>
                                                  </td>
                                                  <td>
                                                      @if($invite->responded_at)
                                                          <small class="text-muted">
                                                              {{ \Carbon\Carbon::parse($invite->responded_at)->format('M d, Y') }}
                                                              <br>{{ \Carbon\Carbon::parse($invite->responded_at)->format('h:i A') }}
                                                          </small>
                                                      @else
                                                          <span class="text-muted">-</span>
                                                      @endif
                                                  </td>
                                              </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                              </div>
                              
                              <!-- Invite Summary Stats -->
                              <div class="row mt-4">
                                  <div class="col-md-3 col-6">
                                      <div class="text-center p-3 bg-light rounded">
                                          <h4 class="mb-1 text-primary">{{ count($event->invites) }}</h4>
                                          <small class="text-muted">Total Invites</small>
                                      </div>
                                  </div>
                                  <div class="col-md-3 col-6">
                                      <div class="text-center p-3 bg-light rounded">
                                          <h4 class="mb-1 text-success">{{ collect($event->invites)->where('status', 'confirmed')->count() }}</h4>
                                          <small class="text-muted">Confirmed</small>
                                      </div>
                                  </div>
                                  <div class="col-md-3 col-6">
                                      <div class="text-center p-3 bg-light rounded">
                                          <h4 class="mb-1 text-warning">{{ collect($event->invites)->where('status', 'pending')->count() }}</h4>
                                          <small class="text-muted">Pending</small>
                                      </div>
                                  </div>
                                  <div class="col-md-3 col-6">
                                      <div class="text-center p-3 bg-light rounded">
                                          <h4 class="mb-1 text-danger">{{ collect($event->invites)->where('status', 'rejected')->count() }}</h4>
                                          <small class="text-muted">Declined</small>
                                      </div>
                                  </div>
                              </div>
                          @else
                              <div class="text-center py-5">
                                  <div class="mb-3">
                                      <i class="fas fa-envelope fa-3x text-muted"></i>
                                  </div>
                                  <h6 class="text-muted mb-3">No invites sent yet</h6>
                                  <p class="text-muted mb-4">Send invites to speakers, VIPs, sponsors, and other special guests for your event.</p>
                                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sendInviteModal">
                                      <i class="fas fa-envelope mr-2"></i>Send First Invite
                                  </button>
                              </div>
                          @endif
                      </div>
                  </div>
              </div>
          </div>
          
          <!-- Recent Sales Section -->
          <div class="row">
             <div class="col-12">
                <h2 class="section-title"> {{__('Recent Sales')}}</h2>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="">
                                <thead>
                                    <tr>
                                        <th>{{__('Order Id')}}</th>
                                        <th>{{__('Customer Name')}}</th>
                                        <th>{{__('Ticket Name')}}</th>
                                        <th>{{__('Date')}}</th>
                                        <th>{{__('Sold Ticket')}}</th>
                                        <th>{{__('Payment')}}</th>
                                        <th>{{__('Payment Gateway')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($event->sales as $item)
                                        <tr>
                                            <td>{{$item->order_id}}</td>
                                            <td>{{$item->customer->name}}</td>
                                            <th>{{$item->ticket->name}}</th>
                                            <th>{{$item->created_at->format('Y-m-d')}}</th>
                                            <th>{{$item->quantity}}</th>
                                            <th>{{$currency.$item->payment}}</th>
                                            <th>{{$item->payment_type}}</th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
             </div>
         </div>
      </div>
    </section>

<!-- Load QR Code library -->
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>

<script>
// Event data for sharing and QR code
const eventData = {
    id: {!! json_encode($event->id) !!},
    name: {!! json_encode($event->name) !!},
    address: {!! json_encode($event->type == 'offline' ? $event->address : 'Online Event') !!},
    start_time: {!! json_encode($event->start_time) !!},
    end_time: {!! json_encode($event->end_time) !!},
    type: {!! json_encode($event->type) !!}
};

// Wait for QR code library to load
function waitForQRCode(callback) {
    if (typeof QRCode !== 'undefined' || typeof qrcode !== 'undefined') {
        callback();
    } else {
        setTimeout(() => waitForQRCode(callback), 100);
    }
}

// Generate QR code for the event
function generateEventQRCode() {
    const eventUrl = `${window.location.origin}/events/${eventData.id}`;
    const canvas = document.getElementById('qr-canvas');
    const placeholder = document.getElementById('qr-placeholder');
    
    console.log('Generating QR code for event:', eventUrl);
    
    // Wait for QR code library to load
    waitForQRCode(() => {
        try {
            // Try using the QRCode library first
            if (typeof QRCode !== 'undefined' && QRCode.toCanvas) {
                QRCode.toCanvas(canvas, eventUrl, {
                    width: 200,
                    height: 200,
                    colorDark: '#000000',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.M
                }, function (error) {
                    if (error) {
                        console.error('QR Code generation failed:', error);
                        generateFallbackEventQR(eventUrl, canvas, placeholder);
                        return;
                    }
                    
                    // Show QR code, hide placeholder
                    canvas.style.display = 'block';
                    placeholder.style.display = 'none';
                });
            } else {
                // Fallback to alternative QR generation
                generateFallbackEventQR(eventUrl, canvas, placeholder);
            }
        } catch (error) {
            console.error('QR Code generation error:', error);
            generateFallbackEventQR(eventUrl, canvas, placeholder);
        }
    });
}

// Fallback QR code generation using API
function generateFallbackEventQR(eventUrl, canvas, placeholder) {
    try {
        const qrApiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(eventUrl)}`;
        
        // Create an image element instead of canvas
        const img = document.createElement('img');
        img.src = qrApiUrl;
        img.style.width = '200px';
        img.style.height = '200px';
        img.style.borderRadius = '8px';
        img.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
        
        // Replace canvas with image
        canvas.style.display = 'none';
        placeholder.innerHTML = '';
        placeholder.appendChild(img);
        placeholder.style.display = 'block';
        
        console.log('Using fallback QR code generation');
    } catch (error) {
        console.error('Fallback QR generation failed:', error);
        placeholder.innerHTML = `
            <div class="text-center p-3">
                <i class="fas fa-qrcode fa-2x text-muted mb-2"></i>
                <p class="text-muted mb-1">QR Code</p>
                <small class="text-muted">Event ID: ${eventData.id}</small>
            </div>
        `;
    }
}

// Download QR code
function downloadEventQR() {
    const canvas = document.getElementById('qr-canvas');
    const placeholder = document.getElementById('qr-placeholder');
    
    // Try to download from canvas first
    if (canvas.style.display !== 'none') {
        try {
            const link = document.createElement('a');
            link.download = `${eventData.name}-qrcode.png`;
            link.href = canvas.toDataURL();
            link.click();
            return;
        } catch (error) {
            console.error('Canvas download failed:', error);
        }
    }
    
    // Try to download from image in placeholder
    const img = placeholder.querySelector('img');
    if (img) {
        try {
            const link = document.createElement('a');
            link.download = `${eventData.name}-qrcode.png`;
            link.href = img.src;
            link.target = '_blank';
            link.click();
            return;
        } catch (error) {
            console.error('Image download failed:', error);
        }
    }
    
    // Fallback: generate new QR code for download
    const eventUrl = `${window.location.origin}/events/${eventData.id}`;
    const qrApiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=${encodeURIComponent(eventUrl)}&download=1`;
    
    const link = document.createElement('a');
    link.download = `${eventData.name}-qrcode.png`;
    link.href = qrApiUrl;
    link.target = '_blank';
    link.click();
}

// Copy event link
function copyEventLink() {
    const eventUrl = `${window.location.origin}/events/${eventData.id}`;
    navigator.clipboard.writeText(eventUrl).then(function() {
        // Show success message
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check mr-1"></i> Copied!';
        btn.classList.add('btn-success');
        btn.classList.remove('btn-outline-secondary');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        alert('Failed to copy link. Please copy manually: ' + eventUrl);
    });
}

// Share on Facebook
function shareEventOnFacebook() {
    const eventUrl = `${window.location.origin}/events/${eventData.id}`;
    const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(eventUrl)}&quote=${encodeURIComponent('Check out this amazing event: ' + eventData.name)}`;
    window.open(shareUrl, '_blank', 'width=600,height=400');
}

// Share on Twitter
function shareEventOnTwitter() {
    const eventUrl = `${window.location.origin}/events/${eventData.id}`;
    const eventDate = new Date(eventData.start_time).toLocaleDateString();
    const tweetText = `🎉 Join me at ${eventData.name}! 📅 ${eventDate} 📍 ${eventData.address}`;
    const shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(tweetText)}&url=${encodeURIComponent(eventUrl)}`;
    window.open(shareUrl, '_blank', 'width=600,height=400');
}

// Share on WhatsApp
function shareEventOnWhatsApp() {
    const eventUrl = `${window.location.origin}/events/${eventData.id}`;
    const eventDate = new Date(eventData.start_time).toLocaleDateString();
    const startTime = new Date(eventData.start_time).toLocaleTimeString();
    const endTime = new Date(eventData.end_time).toLocaleTimeString();
    const message = `🎉 *${eventData.name}*\n\n📅 Date: ${eventDate}\n⏰ Time: ${startTime} - ${endTime}\n📍 Location: ${eventData.address}\n\nJoin me at this amazing event!\n${eventUrl}`;
    const shareUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;
    window.open(shareUrl, '_blank');
}

// Gallery functionality
let galleryImages = [];
let currentImageIndex = 0;

// Initialize gallery images array
function initializeGallery() {
    const galleryThumbnails = document.querySelectorAll('.gallery-thumbnail');
    galleryImages = Array.from(galleryThumbnails).map(img => ({
        src: img.getAttribute('data-image'),
        index: parseInt(img.getAttribute('data-index'))
    }));
}

// Show image in modal
function showGalleryImage(index) {
    if (galleryImages.length === 0) return;
    
    currentImageIndex = index;
    const modalImage = document.getElementById('modalImage');
    const imageCounter = document.getElementById('imageCounter');
    
    modalImage.src = galleryImages[index].src;
    imageCounter.textContent = `${index + 1} of ${galleryImages.length}`;
    
    // Update navigation button visibility
    const prevBtn = document.getElementById('prevImage');
    const nextBtn = document.getElementById('nextImage');
    
    prevBtn.style.display = index === 0 ? 'none' : 'block';
    nextBtn.style.display = index === galleryImages.length - 1 ? 'none' : 'block';
}

// Navigate to previous image
function showPreviousImage() {
    if (currentImageIndex > 0) {
        showGalleryImage(currentImageIndex - 1);
    }
}

// Navigate to next image
function showNextImage() {
    if (currentImageIndex < galleryImages.length - 1) {
        showGalleryImage(currentImageIndex + 1);
    }
}

// Download current gallery image
function downloadGalleryImage() {
    if (galleryImages.length === 0 || currentImageIndex < 0) return;
    
    const currentImage = galleryImages[currentImageIndex];
    const link = document.createElement('a');
    link.download = `${eventData.name}-gallery-${currentImageIndex + 1}.jpg`;
    link.href = currentImage.src;
    link.target = '_blank';
    link.click();
}

// Initialize QR code when page loads
document.addEventListener('DOMContentLoaded', function() {
    generateEventQRCode();
    initializeGallery();
    
    // Gallery thumbnail click handlers
    document.querySelectorAll('.gallery-thumbnail').forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));
            showGalleryImage(index);
        });
    });
    
    // Gallery modal navigation
    document.getElementById('prevImage')?.addEventListener('click', showPreviousImage);
    document.getElementById('nextImage')?.addEventListener('click', showNextImage);
    
    // Keyboard navigation for gallery
    document.addEventListener('keydown', function(e) {
        if (document.getElementById('galleryModal').classList.contains('show')) {
            if (e.key === 'ArrowLeft') {
                showPreviousImage();
            } else if (e.key === 'ArrowRight') {
                showNextImage();
            } else if (e.key === 'Escape') {
                $('#galleryModal').modal('hide');
            }
        }
    });
});
</script>

<style>
/* Enhanced event details styles */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.event-card {
    transition: all 0.3s ease;
}

.event-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}

.qr-card, .sharing-card {
    transition: all 0.3s ease;
}

.qr-card:hover, .sharing-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}

.btn-facebook {
    background-color: #3b5998;
    border-color: #3b5998;
    color: white;
}

.btn-facebook:hover {
    background-color: #2d4373;
    border-color: #2d4373;
    color: white;
}

.info-item {
    transition: all 0.2s ease;
}

.info-item:hover {
    background-color: rgba(0,123,255,0.1);
    border-radius: 4px;
    padding: 4px 8px;
    margin: -4px -8px;
}

#qr-canvas {
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.event-description {
    max-height: 200px;
    overflow-y: auto;
}

/* Gallery styles */
.gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}

.gallery-image-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}

.gallery-thumbnail {
    transition: all 0.3s ease;
}

.gallery-thumbnail:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2) !important;
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 8px;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.gallery-overlay-content {
    text-align: center;
    transform: translateY(10px);
    transition: transform 0.3s ease;
}

.gallery-item:hover .gallery-overlay-content {
    transform: translateY(0);
}

/* Modal navigation buttons */
#prevImage, #nextImage {
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

#prevImage:hover, #nextImage:hover {
    opacity: 1 !important;
    transform: translateY(-50%) scale(1.1);
}

/* Gallery modal image */
#modalImage {
    transition: opacity 0.3s ease;
}

/* Gallery grid responsive adjustments */
@media (max-width: 768px) {
    .gallery-item {
        margin-bottom: 1rem;
    }
    
    .gallery-thumbnail {
        height: 150px !important;
    }
}
</style>

<!-- Send Invite Modal -->
<div class="modal fade" id="sendInviteModal" tabindex="-1" role="dialog" aria-labelledby="sendInviteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="sendInviteModalLabel">
                    <i class="fas fa-envelope mr-2"></i>Send Event Invite
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="sendInviteForm" method="POST" action="{{ route('events.send-invite', $event->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="guest_name" class="form-label">
                                    <i class="fas fa-user mr-1"></i>Guest Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="guest_name" name="guest_name" 
                                       placeholder="Enter guest's full name" required>
                                <small class="form-text text-muted">The name that will appear on the invite</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="guest_email" class="form-label">
                                    <i class="fas fa-envelope mr-1"></i>Guest Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control" id="guest_email" name="guest_email" 
                                       placeholder="guest@example.com" required>
                                <small class="form-text text-muted">Where the invite will be sent</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="invite_type" class="form-label">
                                    <i class="fas fa-tag mr-1"></i>Invite Type <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" id="invite_type" name="invite_type" required>
                                    <option value="">Select invite type</option>
                                    <option value="speaker">Speaker</option>
                                    <option value="vip">VIP Guest</option>
                                    <option value="sponsor">Sponsor</option>
                                    <option value="media">Media/Press</option>
                                    <option value="staff">Staff/Volunteer</option>
                                    <option value="general">General Invite</option>
                                </select>
                                <small class="form-text text-muted">This will appear as the invite title</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="invite_message" class="form-label">
                                    <i class="fas fa-comment mr-1"></i>Personal Message (Optional)
                                </label>
                                <textarea class="form-control" id="invite_message" name="invite_message" rows="3" 
                                          placeholder="Add a personal message to the invite..."></textarea>
                                <small class="form-text text-muted">This message will be included in the invite</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Event Preview -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <h6 class="card-title text-muted mb-2">
                                        <i class="fas fa-eye mr-1"></i>Event Preview
                                    </h6>
                                    <div class="d-flex align-items-center">
                                        <img src="{{url('images/upload/'.$event->image)}}" alt="{{$event->name}}" 
                                             class="rounded mr-3" style="width: 60px; height: 60px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-1">{{$event->name}}</h6>
                                            <p class="mb-0 text-muted small">
                                                <i class="fas fa-calendar mr-1"></i>{{date('M d, Y', strtotime($event->start_time))}}
                                                <i class="fas fa-clock ml-2 mr-1"></i>{{date('h:i A', strtotime($event->start_time))}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-success" id="sendInviteBtn">
                        <i class="fas fa-paper-plane mr-1"></i>Send Invite
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
</style>

<script>
// Handle invite form submission
$(document).ready(function() {
    $('#sendInviteForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = $('#sendInviteBtn');
        const originalText = submitBtn.html();
        
        // Show loading state
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Sending...');
        
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Invite Sent!',
                        text: response.message,
                        timer: 3000,
                        showConfirmButton: false
                    });
                    
                    // Reset form and close modal
                    form[0].reset();
                    $('#sendInviteModal').modal('hide');
                } else {
                    throw new Error(response.message || 'Failed to send invite');
                }
            },
            error: function(xhr) {
                let errorMessage = 'Failed to send invite. Please try again.';
                
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    if (errors) {
                        Object.keys(errors).forEach(function(field) {
                            const input = $(`[name="${field}"]`);
                            input.addClass('is-invalid');
                            input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                        });
                        errorMessage = 'Please check your input and try again.';
                    }
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage
                });
            },
            complete: function() {
                // Reset button state
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
    
    // Reset form when modal is closed
    $('#sendInviteModal').on('hidden.bs.modal', function() {
        $('#sendInviteForm')[0].reset();
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    });
});
</script>

@endsection
