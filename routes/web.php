<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\RepaymentController;
use App\Http\Controllers\CollateralController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LoanProductController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\UserAutoPaymentController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\DisburserController;
use App\Http\Controllers\RepaymentCycleController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\LoanStatusController;
use App\Http\Controllers\LoanCalculatorController;
use App\Http\Controllers\BorrowerGroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SavingsProductController;
use App\Http\Controllers\SavingsAccountController;
use App\Http\Controllers\SavingsTransactionController;

Route::get('/', fn () => view('welcome'));

Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });

    Route::resource('borrowers', BorrowerController::class);
    Route::post('/borrowers/check-duplicate', [BorrowerController::class, 'checkDuplicate'])->name('borrowers.check-duplicate');

    Route::resource('loans', LoanController::class);
    Route::get('/get-loans-by-borrower/{borrowerId}', [CollateralController::class, 'getLoansByBorrower'])->name('collaterals.get-loans-by-borrower');

    Route::resource('repayments', RepaymentController::class);
    Route::get('/repayments/recent', [RepaymentController::class, 'recentRepayments'])->name('repayments.recent');
    Route::get('/repayments/history', [RepaymentController::class, 'history'])->name('repayments.history');

    Route::resource('repayment_cycles', RepaymentCycleController::class);

    Route::resource('collaterals', CollateralController::class);
    Route::get('/collaterals/search', [CollateralController::class, 'search'])->name('collaterals.search');
    Route::get('/collaterals/branch-register', [CollateralController::class, 'branchRegister'])->name('collaterals.branch-register');

    Route::get('/payments/create', [PaymentController::class, 'showPaymentForm'])->name('payment.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/payments/verify/{paymentId}', [PaymentController::class, 'verifyPayment'])->name('payment.verify');
    Route::post('/payments/process', [PaymentController::class, 'process'])->name('payment.process');

    Route::resource('plans', PlanController::class);

    Route::get('/chat', [ChatController::class, 'index'])->name('user.chat');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('user.chat.send');

    
   

    // Branch Routes
    Route::resource('branches', BranchController::class);
    Route::get('/branches/assignments', [BranchController::class, 'assignments'])->name('branch.assignments');
    
    // Branch Settings Routes
    Route::prefix('branches')->name('branches.')->group(function () {
        Route::get('{branch}/settings', [BranchSettingsController::class, 'edit'])->name('settings.edit'); // Form for editing settings
        Route::put('{branch}/settings', [BranchSettingsController::class, 'update'])->name('settings.update'); // Update settings
    });

    Route::prefix('savings-transactions')->name('savings-transactions.')->group(function () {
        Route::get('/', [SavingsTransactionController::class, 'index'])->name('index');
        Route::get('/create', [SavingsTransactionController::class, 'create'])->name('create');
        Route::post('/', [SavingsTransactionController::class, 'store'])->name('store');
        Route::get('/{savingsTransaction}', [SavingsTransactionController::class, 'show'])->name('show');
        Route::get('/{savingsTransaction}/edit', [SavingsTransactionController::class, 'edit'])->name('edit');
        Route::put('/{savingsTransaction}', [SavingsTransactionController::class, 'update'])->name('update');
        Route::delete('/{savingsTransaction}', [SavingsTransactionController::class, 'destroy'])->name('destroy');
    });

    
    Route::prefix('admin/command')->name('admin.command.')->group(function () {
        Route::get('/', [CommandController::class, 'index'])->name('index');
        Route::get('/manage-users', [CommandController::class, 'manageUsers'])->name('manageUsers');
        Route::post('/update-user-status', [CommandController::class, 'updateUserStatus'])->name('updateUserStatus');
        Route::post('/verify-user', [CommandController::class, 'verifyUser'])->name('verifyUser');
        Route::get('/chat/{userId}', [CommandController::class, 'chatWithUser'])->name('chat');
        Route::post('/send-message', [CommandController::class, 'sendMessage'])->name('sendMessage');
    });

    Route::resource('expenses', ExpenseController::class);
    Route::get('/export-expenses', [ExpenseController::class, 'export'])->name('expenses.export');

    Route::resource('loanProducts', LoanProductController::class);

    Route::prefix('auto-payments')->name('auto-payments.')->group(function () {
        Route::get('/trigger', [UserAutoPaymentController::class, 'triggerAutoPayments'])->name('trigger');
        Route::get('/status/{loanId}', [UserAutoPaymentController::class, 'viewLoanPaymentsStatus'])->name('status');
        Route::post('/toggle/{loanId}', [UserAutoPaymentController::class, 'toggleAutoPayments'])->name('toggle');
    });

    Route::resource('fees', FeeController::class);
    Route::resource('disbursers', DisburserController::class);

    Route::prefix('loan')->group(function () {
        Route::get('banks', [BankController::class, 'index'])->name('banks.index');
        Route::get('banks/create', [BankController::class, 'create'])->name('banks.create');
        Route::post('banks', [BankController::class, 'store'])->name('banks.store');
        Route::get('banks/{bank}', [BankController::class, 'show'])->name('banks.show');
        Route::get('banks/{bank}/edit', [BankController::class, 'edit'])->name('banks.edit');
        Route::put('banks/{bank}', [BankController::class, 'update'])->name('banks.update');
        Route::delete('banks/{bank}', [BankController::class, 'destroy'])->name('banks.destroy');
    });

    Route::prefix('savings/products')->name('savings.products.')->group(function () {
        Route::get('/', [SavingsProductController::class, 'index'])->name('index');
        Route::get('/create', [SavingsProductController::class, 'create'])->name('create');
        Route::post('/store', [SavingsProductController::class, 'store'])->name('store');
        Route::get('/{savingsProduct}/edit', [SavingsProductController::class, 'edit'])->name('edit');
        Route::put('/{savingsProduct}', [SavingsProductController::class, 'update'])->name('update');
        Route::delete('/{savingsProduct}', [SavingsProductController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('savings-accounts')->name('savings-accounts.')->group(function () {
        Route::get('/', [SavingsAccountController::class, 'index'])->name('index');
        Route::get('/create', [SavingsAccountController::class, 'create'])->name('create');
        Route::post('/', [SavingsAccountController::class, 'store'])->name('store');
        Route::get('/{savingsAccount}', [SavingsAccountController::class, 'show'])->name('show');
        Route::get('/{savingsAccount}/edit', [SavingsAccountController::class, 'edit'])->name('edit');
        Route::put('/{savingsAccount}', [SavingsAccountController::class, 'update'])->name('update');
        Route::delete('/{savingsAccount}', [SavingsAccountController::class, 'destroy'])->name('destroy');
    });

    
    Route::resource('bank_accounts', BankAccountController::class)->parameters(['bank_accounts' => 'bankAccount']);

    Route::resource('loan-statuses', LoanStatusController::class);
    Route::post('/loan-statuses/reorder', [LoanStatusController::class, 'reorder'])->name('loan-statuses.reorder');

    Route::post('/loan-calculator/preview', [LoanCalculatorController::class, 'preview'])->name('loan.calculator.preview');

    Route::resource('borrower-groups', BorrowerGroupController::class);
});

Route::middleware('auth')->get('/payment', [PaymentController::class, 'form'])->name('payment.form');
Route::get('/confirm-password', fn () => view('auth.confirm-password'))->middleware('auth')->name('password.confirm');

require __DIR__ . '/auth.php';
