@extends('user-master')
@section('title', __('My Wallet'))
@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('My Wallet') }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('userDashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('My Wallet') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Wallet Balance Card -->
        <div class="col-xl-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title mb-0">{{ __('Wallet Balance') }}</h4>
                        <a href="{{ route('addToWallet') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> {{ __('Add Money') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="wallet-balance-box text-center p-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; color: white;">
                                <i class="fas fa-wallet fa-3x mb-3 opacity-75"></i>
                                <h2 class="mb-2 font-weight-bold">{{ $balance }}</h2>
                                <p class="mb-0 opacity-75">{{ __('Available Balance') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="wallet-stats">
                                <div class="stat-item mb-3 p-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon me-3">
                                            <i class="fas fa-arrow-down text-success fa-lg"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">{{ __('Total Deposits') }}</h6>
                                            <p class="mb-0 text-muted">{{ $transactions->where('type', 'deposit')->sum('amount') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="stat-item mb-3 p-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon me-3">
                                            <i class="fas fa-arrow-up text-danger fa-lg"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">{{ __('Total Withdrawals') }}</h6>
                                            <p class="mb-0 text-muted">{{ $transactions->where('type', 'withdraw')->sum('amount') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="stat-item p-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon me-3">
                                            <i class="fas fa-exchange-alt text-info fa-lg"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">{{ __('Total Transactions') }}</h6>
                                            <p class="mb-0 text-muted">{{ $transactions->count() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="col-xl-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">{{ __('Quick Actions') }}</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('addToWallet') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-plus-circle me-2"></i>
                            {{ __('Add Money to Wallet') }}
                        </a>
                        <a href="{{ route('userOrders') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-cart me-2"></i>
                            {{ __('View My Orders') }}
                        </a>
                        <a href="{{ route('userProfile') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-user me-2"></i>
                            {{ __('Update Profile') }}
                        </a>
                    </div>
                    
                    <!-- Wallet Tips -->
                    <div class="mt-4">
                        <h6 class="text-muted mb-3">{{ __('Wallet Tips') }}</h6>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>{{ __('Use your wallet balance to quickly purchase event tickets without entering payment details every time.') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title mb-0">{{ __('Transaction History') }}</h4>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <select class="form-select form-select-sm" id="transactionFilter">
                                    <option value="all">{{ __('All Transactions') }}</option>
                                    <option value="deposit">{{ __('Deposits Only') }}</option>
                                    <option value="withdraw">{{ __('Withdrawals Only') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($transactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">{{ __('Type') }}</th>
                                        <th scope="col">{{ __('Amount') }}</th>
                                        <th scope="col">{{ __('Payment Mode') }}</th>
                                        <th scope="col">{{ __('Transaction ID') }}</th>
                                        <th scope="col">{{ __('Date & Time') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr class="transaction-row" data-type="{{ $transaction->type }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($transaction->type === 'deposit')
                                                        <div class="avatar-xs me-3">
                                                            <span class="avatar-title rounded-circle bg-success-subtle text-success">
                                                                <i class="fas fa-arrow-down"></i>
                                                            </span>
                                                        </div>
                                                        <span class="badge bg-success-subtle text-success">{{ __('Deposit') }}</span>
                                                    @else
                                                        <div class="avatar-xs me-3">
                                                            <span class="avatar-title rounded-circle bg-danger-subtle text-danger">
                                                                <i class="fas fa-arrow-up"></i>
                                                            </span>
                                                        </div>
                                                        <span class="badge bg-danger-subtle text-danger">{{ __('Withdrawal') }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-semibold @if($transaction->type === 'deposit') text-success @else text-danger @endif">
                                                    @if($transaction->type === 'deposit')+@else-@endif{{ $transaction->amount }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $transaction->meta['payment_mode'] ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <code class="text-muted">{{ $transaction->meta['token'] ?? 'N/A' }}</code>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y, H:i') }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success">{{ __('Completed') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="avatar-lg mx-auto mb-4">
                                <div class="avatar-title bg-light text-muted rounded-circle">
                                    <i class="fas fa-receipt fa-2x"></i>
                                </div>
                            </div>
                            <h5 class="text-muted">{{ __('No Transactions Yet') }}</h5>
                            <p class="text-muted mb-4">{{ __('Your wallet transaction history will appear here once you make your first deposit or withdrawal.') }}</p>
                            <a href="{{ route('addToWallet') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> {{ __('Add Money Now') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Transaction filter functionality
    $('#transactionFilter').on('change', function() {
        const filterValue = $(this).val();
        
        $('.transaction-row').each(function() {
            const transactionType = $(this).data('type');
            
            if (filterValue === 'all' || filterValue === transactionType) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert-dismissible').fadeOut('slow');
    }, 5000);
});
</script>
@endsection
