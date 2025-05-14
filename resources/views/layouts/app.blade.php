<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | FundEase</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #f7fafc;
      color: #333;
    }
    .inactive-button {
      opacity: 0.5;
      cursor: not-allowed;
      pointer-events: none;
    }
    .payment-reminder {
      background-color: #fffbdd;
      color: #856404;
      padding: 20px;
      text-align: center;
      font-weight: bold;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 50;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body class="bg-gray-100">

  <!-- Notification Messages -->
  @if(session('success'))
    <div x-data="{ open: true }" x-show="open" x-init="setTimeout(() => open = false, 5000)" class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-50">
      <p>{{ session('success') }}</p>
    </div>
  @endif

  @if(session('error'))
    <div x-data="{ open: true }" x-show="open" x-init="setTimeout(() => open = false, 5000)" class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded shadow-lg z-50">
      <p>{{ session('error') }}</p>
    </div>
  @endif

  @auth
    @if(auth()->user()->status === 'inactive')
      <div class="payment-reminder" id="payment-banner">
        <p class="text-xl">Payment Required!</p>
        <p class="mt-2">Please complete your payment to unlock full access.</p>
        <a href="{{ route('payment.form') }}" class="inline-block bg-blue-500 text-white px-4 py-2 mt-4 rounded hover:bg-blue-600 transition">
          Proceed to Payment
        </a>
      </div>
      <div style="margin-top: 120px;"></div>
    @endif
  @endauth

  <div class="flex h-screen">
    <!-- Sidebar -->
    <aside
      x-data="{ collapsed: localStorage.getItem('sidebarCollapsed') === 'true' }"
      x-init="$watch('collapsed', val => localStorage.setItem('sidebarCollapsed', val))"
      :class="collapsed ? 'w-20' : 'w-64'"
      class="bg-white shadow-md transition-all duration-300 p-5 relative h-full overflow-y-auto"
    >
      <button @click="collapsed = !collapsed"
              class="absolute top-4 right-2 p-2 bg-gray-300 rounded text-gray-700 hover:bg-gray-400">
        <i class="fas fa-bars"></i>
      </button>
      <nav class="mt-12">
        <ul>
          <!-- Dashboard -->
          <li>
            <a href="{{ route('dashboard') }} "
               class="flex items-center p-3 rounded hover:bg-gray-200 {{ (auth()->check() && auth()->user()->status === 'inactive') ? 'inactive-button' : '' }} "
               onclick="checkInactive(event)">
              <i class="fas fa-tachometer-alt mr-3"></i>
              <span x-show="!collapsed">Dashboard</span>
            </a>
          </li>

          <!-- Admin Command -->
          @auth
            @if(auth()->user()->is_admin)
              <li>
                <a href="{{ route('admin.command') }} "
                   class="flex items-center p-3 rounded hover:bg-gray-200"
                   onclick="checkInactive(event)">
                  <i class="fas fa-terminal mr-3"></i>
                  <span x-show="!collapsed">Command Feature</span>
                </a>
              </li>
            @endif
          @endauth
          
          <!-- Borrowers -->
          <li x-data="{ open: {{ request()->routeIs('borrowers.*') ? 'true' : 'false' }} }">
            <button @click="open=!open"
                    class="w-full flex justify-between items-center p-3 rounded hover:bg-gray-200 {{ (auth()->check() && auth()->user()->status === 'inactive') ? 'inactive-button' : '' }} "
                    onclick="checkInactive(event)">
              <span class="flex items-center">
                <i class="fas fa-user-friends mr-3"></i>
                <span x-show="!collapsed">Borrowers</span>
              </span>
              <i class="fas fa-chevron-down" :class="{'rotate-180':open}"></i>
            </button>
            <ul x-show="open && !collapsed" class="ml-8 mt-2 space-y-1" x-transition>
              <li><a href="{{ route('borrowers.index') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-list mr-2"></i>All Borrowers</a></li>
              <li><a href="{{ route('borrowers.create') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-user-plus mr-2"></i>Add Borrower</a></li>
            </ul>
          </li>

          <!-- Loans & Submenus -->
          <li x-data="{ open: {{ (request()->routeIs('loans.*') || request()->routeIs('loanProducts.*') || request()->routeIs('repayment_cycles.*') || request()->routeIs('disbursers.*') || request()->routeIs('loan-statuses.*') || request()->routeIs('bank-accounts.*')) ? 'true' : 'false' }} }">
            <button @click="open=!open"
                    class="w-full flex justify-between items-center p-3 rounded hover:bg-gray-200 {{ (auth()->check() && auth()->user()->status === 'inactive') ? 'inactive-button' : '' }} "
                    onclick="checkInactive(event)">
              <span class="flex items-center">
                <i class="fas fa-hand-holding-usd mr-3"></i>
                <span x-show="!collapsed">Loans</span>
              </span>
              <i class="fas fa-chevron-down" :class="{'rotate-180':open}"></i>
            </button>
            <ul x-show="open && !collapsed" class="ml-8 mt-2 space-y-1" x-transition>
              <li><a href="{{ route('loans.index') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-list mr-2"></i>All Loans</a></li>
              <li><a href="{{ route('loans.create') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-plus-circle mr-2"></i>Add Loan</a></li>
              <li><a href="{{ route('loanProducts.index') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-boxes mr-2"></i>All Loan Products</a></li>
              <li><a href="{{ route('loanProducts.create') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-plus-circle mr-2"></i>Add Loan Product</a></li>
              <li><a href="{{ route('fees.index') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-credit-card mr-2"></i>Manage Fees</a></li>
              <li><a href="{{ route('repayment_cycles.index') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-sync-alt mr-2"></i>All Repayment Cycles</a></li>
              <li><a href="{{ route('repayment_cycles.create') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-plus-circle mr-2"></i>Add Repayment Cycle</a></li>
              <li><a href="{{ route('disbursers.index') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-handshake mr-2"></i>Disbursers</a></li>
              <li><a href="{{ route('loan-statuses.index') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-clipboard-check mr-2"></i>Loan Statuses</a></li>
              <li><a href="{{ route('loan-statuses.create') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-plus-circle mr-2"></i>Add Loan Status</a></li>
              <li><a href="{{ route('bank_accounts.index') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-wallet mr-2"></i>View Bank Accounts</a></li>
              <li><a href="{{ route('bank_accounts.create') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-plus-circle mr-2"></i>Add Bank Account</a></li>
            </ul>
          </li>

    <!-- Branch Feature - Now Independent -->
<li x-data="{ open: {{ request()->routeIs('branches.*') ? 'true' : 'false' }} }">
  <button @click="open=!open"
          class="w-full flex justify-between items-center p-3 rounded hover:bg-gray-200 {{ (auth()->check() && auth()->user()->status === 'inactive') ? 'inactive-button' : '' }} "
          onclick="checkInactive(event)">
    <span class="flex items-center">
      <i class="fas fa-building mr-3"></i>
      <span x-show="!collapsed">Branches</span>
    </span>
    <i class="fas fa-chevron-down" :class="{'rotate-180':open}"></i>
  </button>
  <ul x-show="open && !collapsed" class="ml-8 mt-2 space-y-1" x-transition>
    <li><a href="{{ route('branches.index') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-list mr-2"></i>All Branches</a></li>
    <li><a href="{{ route('branches.create') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-plus-circle mr-2"></i>Add Branch</a></li>
    
    <!-- Conditional Branch Settings Link -->
    @isset($branch)
      <li><a href="{{ route('branches.settings.edit', $branch) }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-cogs mr-2"></i>Branch Settings</a></li>
    @endisset
  </ul>
</li>


          <!-- Savings Feature -->
          <li x-data="{ open: {{ request()->routeIs('savings.products.*') || request()->routeIs('savings-accounts.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
              class="w-full flex justify-between items-center p-3 rounded hover:bg-gray-200 {{ (auth()->check() && auth()->user()->status === 'inactive') ? 'inactive-button' : '' }} "
              onclick="checkInactive(event)">
              <span class="flex items-center">
                <i class="fas fa-piggy-bank mr-3"></i>
                <span x-show="!collapsed">Savings</span>
              </span>
              <i class="fas fa-chevron-down" :class="{'rotate-180': open}"></i>
            </button>
            <ul x-show="open && !collapsed" class="ml-8 mt-2 space-y-1" x-transition>
              <li><a href="{{ route('savings.products.index') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-list mr-2"></i>View Savings Products</a></li>
              <li><a href="{{ route('savings.products.create') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-plus-circle mr-2"></i>Add Savings Product</a></li>
              <li><a href="{{ route('savings-accounts.index') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-eye mr-2"></i>View Savings Accounts</a></li>
              <li><a href="{{ route('savings-accounts.create') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-plus-circle mr-2"></i>Add Savings Account</a></li>
            </ul>
          </li>

          <!-- Savings Transactions Feature -->
          <li x-data="{ open: {{ request()->routeIs('savings-transactions.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
              class="w-full flex justify-between items-center p-3 rounded hover:bg-gray-200 {{ (auth()->check() && auth()->user()->status === 'inactive') ? 'inactive-button' : '' }} "
              onclick="checkInactive(event)">
              <span class="flex items-center">
                <i class="fas fa-money-check-alt mr-3"></i>
                <span x-show="!collapsed">Savings Transactions</span>
              </span>
              <i class="fas fa-chevron-down" :class="{'rotate-180': open}"></i>
            </button>
            <ul x-show="open && !collapsed" class="ml-8 mt-2 space-y-1" x-transition>
              <li><a href="{{ route('savings-transactions.index') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-list mr-2"></i>View Transactions</a></li>
              <li><a href="{{ route('savings-transactions.create') }}" class="flex items-center p-2 rounded hover:bg-gray-200"><i class="fas fa-plus-circle mr-2"></i>Add Transaction</a></li>
            </ul>
          </li>

        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-y-auto h-full">
      @yield('content')
    </main>
  </div>

  <script>
    function checkInactive(event) {
      if (document.querySelector('.payment-reminder')) {
        event.preventDefault();
        alert("Please complete your payment to access this feature.");
      }
    }
  </script>
</body>
</html>
