@extends('master')

@section('content')
    <!-- Enhanced Dashboard Styles -->
    <style>
        /* Modern Dashboard Enhancements */
        .modern-stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 15px;
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .modern-stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .modern-stats-card.success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .modern-stats-card.warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .modern-stats-card.info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stats-icon {
            font-size: 3rem;
            opacity: 0.8;
            margin-bottom: 1rem;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stats-label {
            font-size: 1rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .quick-action-btn {
          /*background: rgba(255,255,255,0.2);*/
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            border-radius: 25px;
            padding: 8px 20px;
            margin: 5px;
            transition: all 0.3s ease;
        }

        .quick-action-btn:hover {
            background: rgba(255,255,255,0.3);
            color: white;
            transform: translateY(-2px);
        }

        .modern-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: box-shadow 0.3s ease;
        }

        .modern-card:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .section-title-modern {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 0;
        }

        .progress-modern {
            height: 8px;
            border-radius: 10px;
            background: #e2e8f0;
        }

        .progress-bar-modern {
            border-radius: 10px;
            background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
        }
    </style>

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Dashboard') }} </h1>
            <div class="section-header-button">
                <a href="{{ route('event.create') }}" class="btn btn-primary quick-action-btn">
                    <i class="fas fa-plus mr-2"></i>{{ __('Create Event') }}
                </a>
                <button class="btn btn-success quick-action-btn" onclick="scrollToAnalytics()">
                    <i class="fas fa-chart-line mr-2"></i>{{ __('Analytics') }}
                </button>
            </div>
        </div>

        <div class="section-body">
            <!-- Enhanced Statistics Cards -->
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card modern-stats-card mb-4">
                        <div class="card-body text-center">
                            <div class="stats-icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="stats-number">{{ $master['total_order'] }}</div>
                            <div class="stats-label">{{ __('Total Orders') }}</div>
                            <div class="mt-3">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <small>{{ __('Pending') }}</small>
                                        <div class="font-weight-bold">{{ $master['pending_order'] }}</div>
                                    </div>
                                    <div class="col-4">
                                        <small>{{ __('Completed') }}</small>
                                        <div class="font-weight-bold">{{ $master['complete_order'] }}</div>
                                    </div>
                                    <div class="col-4">
                                        <small>{{ __('Cancelled') }}</small>
                                        <div class="font-weight-bold">{{ $master['cancel_order'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card modern-stats-card success mb-4">
                        <div class="card-body text-center">
                            <div class="stats-icon">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <div class="stats-number">{{ $master['used_tickets'] }}/{{ $master['total_tickets'] }}</div>
                            <div class="stats-label">{{ __('Tickets Sold') }}</div>
                            <div class="mt-3">
                                @php
                                    $percentage = $master['total_tickets'] > 0 ? ($master['used_tickets'] / $master['total_tickets']) * 100 : 0;
                                @endphp
                                <div class="progress progress-modern">
                                    <div class="progress-bar progress-bar-modern" style="width: {{ $percentage }}%"></div>
                                </div>
                                <small class="mt-2 d-block">{{ number_format($percentage, 1) }}% {{ __('Sold') }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card modern-stats-card info mb-4">
                        <div class="card-body text-center">
                            <div class="stats-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stats-number">{{ $master['events'] }}</div>
                            <div class="stats-label">{{ __('Total Events') }}</div>
                            <div class="mt-3">
                                <button class="quick-action-btn btn-sm">
                                    <i class="fas fa-eye mr-1"></i>{{ __('View All') }}
                                </button>
                                <button class="quick-action-btn btn-sm">
                                    <i class="fas fa-plus mr-1"></i>{{ __('Create New') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Upcoming Events Card -->
                            <div class="card modern-card mb-4">
                                <div class="card-header pt-0 pb-0">
                                    <div class="row w-100">
                                        <div class="col-lg-8">
                                            <h2 class="section-title-modern"> {{ __('Upcoming Event') }}</h2>
                                        </div>
                                        <div class="col-lg-4 text-right mt-2">
                                            <a href="{{ url('events') }}"><button
                                                    class="btn btn-sm btn-primary ">{{ __('See all') }}</button> </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if(count($events) > 0)
                                        <div class="table-responsive">
                                            <table class="table home-tbl" id="">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('Event') }}</th>
                                                        <th>{{ __('Location') }}</th>
                                                        <th>{{ __('Capacity') }}</th>
                                                        <th>{{ __('Tickets Left') }}</th>
                                                        <th>{{ __('Date') }}</th>
                                                        <th>{{ __('Actions') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($events as $item)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img class="table-img rounded mr-3"
                                                                        src="{{ url('images/upload/' . $item->image) }}"
                                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                                    <div>
                                                                        <h6 class="mb-0">{{ $item->name }}</h6>
                                                                        <small class="text-muted">{{ $item->category->name ?? 'General' }}</small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @if ($item->type == 'online')
                                                                    <span class="badge badge-info">{{ __('Online Event') }}</span>
                                                                @else
                                                                    <i class="fas fa-map-marker-alt text-primary mr-1"></i>
                                                                    {{ Str::limit($item->address, 30) }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <i class="fas fa-user-friends text-success mr-2"></i>
                                                                    <span class="font-weight-bold">{{ $item->people }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <i class="fas fa-ticket-alt text-warning mr-2"></i>
                                                                    <span class="font-weight-bold {{ $item->avaliable < 10 ? 'text-danger' : 'text-success' }}">
                                                                        {{ $item->avaliable }}
                                                                    </span>
                                                                    @if($item->avaliable < 10)
                                                                        <span class="badge badge-danger ml-2">{{ __('Low Stock') }}</span>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <i class="far fa-calendar-alt text-info mr-2"></i>
                                                                    <div>
                                                                        <div class="font-weight-bold">{{ $item->start_time->format('M d, Y') }}</div>
                                                                        <small class="text-muted">{{ $item->start_time->format('g:i A') }}</small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <a href="{{ url('/events_details/' . $item->id) }}" class="btn btn-sm btn-outline-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ url('/events/' . $item->id . '/edit') }}" class="btn btn-sm btn-outline-warning">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <button class="btn btn-sm btn-outline-success" onclick="shareEvent({{ $item->id }})">
                                                                        <i class="fas fa-share-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-calendar-plus text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                                                <h4 class="mt-3 text-muted">{{ __('No Upcoming Events') }}</h4>
                                                <p class="text-muted">{{ __('Create your first event to get started') }}</p>
                                                <a href="{{ route('event.create') }}" class="btn btn-primary mt-3">
                                                    <i class="fas fa-plus mr-2"></i>{{ __('Create Event') }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Analytics & Charts Section -->
                    <div class="row mb-4">
                        <div class="col-lg-8">
                            <div class="card modern-card">
                                <div class="card-header">
                                    <h4 class="section-title-modern">{{ __('Sales Analytics') }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                                        <canvas id="salesChart" width="800" height="300"></canvas>
                                    </div>

                                    <!-- Fallback: Show data in table format if chart fails -->
                                    <div id="chartFallback" style="display: none;">
                                        <h6>Sales Data (Chart Loading Failed)</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Monthly Ticket Sales:</strong>
                                                <div id="salesDataDisplay"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Monthly Revenue:</strong>
                                                <div id="revenueDataDisplay"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card modern-card">
                                <div class="card-header">
                                    <h4 class="section-title-modern">{{ __('Quick Stats') }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="stat-item mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>This Month Revenue</span>
                                            <span class="font-weight-bold text-success">{{ $master['currency'] ?? '$' }}{{ number_format($master['thisMonthRevenue'] ?? 0, 2) }}</span>
                                        </div>
                                        <div class="progress progress-modern mt-2">
                                            <div class="progress-bar progress-bar-modern" style="width: {{ $master['monthRevenueProgress'] ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                    <div class="stat-item mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Tickets Sold Today</span>
                                            <span class="font-weight-bold text-primary">{{ $master['ticketsSoldToday'] ?? 0 }}</span>
                                        </div>
                                        <div class="progress progress-modern mt-2">
                                            <div class="progress-bar progress-bar-modern" style="width: {{ $master['dailyTicketsProgress'] ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Active Events</span>
                                            <span class="font-weight-bold text-info">{{ $master['activeEvents'] ?? 0 }}</span>
                                        </div>
                                        <div class="progress progress-modern mt-2">
                                            <div class="progress-bar progress-bar-modern" style="width: {{ $master['activeEventsProgress'] ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                    <div class="stat-item mt-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Total Tickets Sold</span>
                                            <span class="font-weight-bold text-warning">{{ number_format($master['totalTicketsSold'] ?? 0) }}</span>
                                        </div>
                                        <div class="progress progress-modern mt-2">
                                            <div class="progress-bar progress-bar-modern bg-warning" style="width: {{ $master['totalTicketsProgress'] ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                    <div class="stat-item mt-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Total Events Created</span>
                                            <span class="font-weight-bold text-secondary">{{ number_format($master['totalEventsCreated'] ?? 0) }}</span>
                                        </div>
                                        <div class="progress progress-modern mt-2">
                                            <div class="progress-bar progress-bar-modern bg-secondary" style="width: {{ $master['totalEventsProgress'] ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

    <script>
        // Function to scroll to analytics section
        function scrollToAnalytics() {
            const analyticsSection = document.querySelector('#salesChart');
            if (analyticsSection) {
                analyticsSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }

        // Initialize chart when page loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing chart...');

            // Get data from PHP
            const salesData = {!! json_encode($master['salesAnalytics'] ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]) !!};
            const revenueData = {!! json_encode($master['revenueAnalytics'] ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]) !!};
            const monthLabels = {!! json_encode($master['monthLabels'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']) !!};
            const currency = '{{ $master['currency'] ?? "$" }}';

            console.log('Chart data loaded:', {
                salesData: salesData,
                revenueData: revenueData,
                monthLabels: monthLabels,
                currency: currency
            });

            // Show fallback data first
            showFallbackData(salesData, revenueData, monthLabels, currency);

            // Try to initialize chart
            setTimeout(function() {
                initializeChart(salesData, revenueData, monthLabels, currency);
            }, 1000);
        });

        function showFallbackData(salesData, revenueData, monthLabels, currency) {
            let salesHtml = '<ul class="list-unstyled">';
            let revenueHtml = '<ul class="list-unstyled">';

            for (let i = 0; i < monthLabels.length; i++) {
                salesHtml += `<li><small>${monthLabels[i]}: ${salesData[i]} tickets</small></li>`;
                revenueHtml += `<li><small>${monthLabels[i]}: ${currency}${revenueData[i]}</small></li>`;
            }

            salesHtml += '</ul>';
            revenueHtml += '</ul>';

            document.getElementById('salesDataDisplay').innerHTML = salesHtml;
            document.getElementById('revenueDataDisplay').innerHTML = revenueHtml;

            // Show fallback initially
            document.getElementById('chartFallback').style.display = 'block';
        }

        function initializeChart(salesData, revenueData, monthLabels, currency) {
            const canvas = document.getElementById('salesChart');

            if (!canvas) {
                console.error('Canvas element not found');
                return;
            }

            if (typeof Chart === 'undefined') {
                console.error('Chart.js not loaded');
                return;
            }

            try {
                const ctx = canvas.getContext('2d');

                // Destroy existing chart
                if (window.salesChartInstance) {
                    window.salesChartInstance.destroy();
                }

                console.log('Creating new chart...');

                window.salesChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: monthLabels,
                        datasets: [{
                            label: 'Tickets Sold',
                            data: salesData,
                            borderColor: '#4facfe',
                            backgroundColor: 'rgba(79, 172, 254, 0.1)',
                            tension: 0.3,
                            fill: true,
                            borderWidth: 2
                        }, {
                            label: `Revenue (${currency})`,
                            data: revenueData,
                            borderColor: '#f093fb',
                            backgroundColor: 'rgba(240, 147, 251, 0.1)',
                            tension: 0.3,
                            fill: true,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        }
                    }
                });

                console.log('Chart created successfully');

                // Hide fallback if chart works
                document.getElementById('chartFallback').style.display = 'none';

            } catch (error) {
                console.error('Chart creation failed:', error);
                // Keep fallback visible
            }
        }

        // Share Event Function
        function shareEvent(eventId) {
            const shareUrl = `${window.location.origin}/events/${eventId}`;

            if (navigator.share) {
                navigator.share({
                    title: 'Check out this event!',
                    url: shareUrl
                }).catch(err => {
                    console.log('Error sharing:', err);
                    copyToClipboard(shareUrl);
                });
            } else {
                copyToClipboard(shareUrl);
            }
        }

        // Copy to clipboard function
        function copyToClipboard(text) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    showToast('Event link copied to clipboard!', 'success');
                }).catch(() => {
                    fallbackCopyTextToClipboard(text);
                });
            } else {
                fallbackCopyTextToClipboard(text);
            }
        }

        // Fallback copy function
        function fallbackCopyTextToClipboard(text) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
                showToast('Event link copied to clipboard!', 'success');
            } catch (err) {
                showToast('Failed to copy link', 'error');
            }
            document.body.removeChild(textArea);
        }

        // Toast notification function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
            toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            toast.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-2"></i>
                    ${message}
                </div>
            `;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    </script>
@endsection
