<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; 

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Depot_Officer\DepotofficerController;
use App\Http\Controllers\ConsumerController;

use App\Http\Controllers\Admin\AllocationController;

use App\Http\Controllers\UserController;





Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test-error', function () {
//     abort(429);
// });

// --- THE TRAFFIC CONTROLLER ---
Route::middleware(['auth', 'verified'])->get('/dashboard', function (Request $request) {
    $user = $request->user();

    return match($user->role) {
        'admin'  => redirect()->route('admin.dashboard'),
        'consumer' => redirect()->route('consumer.dashboard'),
        'depot_officer' => redirect()->route('depot.dashboard'),
        default  => abort(403), 
    };
})->name('dashboard');


// --- PROTECTED ROUTES ---
Route::middleware(['auth', 'role:consumer'])->prefix('consumer')->name('consumer.')->group(function () {
    // Change this line:
    Route::get('/dashboard', [ConsumerController::class, 'index'])->name('dashboard');

    // for the individual product view
    Route::get('/allocations/{batch}', [ConsumerController::class, 'show'])->name('allocations.show');
    // for the order form
    Route::post('/orders', [ConsumerController::class, 'storeOrder'])->name('orders.store');
    Route::get('/orders/{order}/pay', [ConsumerController::class, 'payOrder'])->name('orders.pay');
    Route::get('/my-orders', [ConsumerController::class, 'orders'])->name('orders.index');

    Route::get('/orders/verify', [ConsumerController::class, 'verifyPayment'])->name('orders.verify');
    Route::get('/orders/{order}/details', [ConsumerController::class, 'orderDetails'])->name('orders.details');

    
});



// --- DEPOT OFFICER ROUTES ---
Route::middleware(['auth', 'role:depot_officer'])->prefix('depot')->name('depot.')->group(function () {
    Route::get('/dashboard', [DepotofficerController::class, 'dashboard'])->name('dashboard');
    // Intake Management (Checking/Flagging incoming custom stock)
    Route::get('/intake', [DepotofficerController::class, 'intakeList'])->name('intake.index');
    Route::post('/intake/{item}/damage', [DepotofficerController::class, 'flagDamage'])->name('intake.damage');

    // Live Verification Scanning & Lookups
    Route::get('/verify', [DepotofficerController::class, 'verifyLookup'])->name('verify.lookup');
    Route::post('/verify/collect', [DepotofficerController::class, 'processCollection'])->name('verify.collect');

    Route::get('/allocation/{allocation}/orders', [DepotofficerController::class, 'allocationOrders'])->name('allocation.orders');
    // Tier 2 -> Tier 3: View individual item tags for an order
    Route::get('/orders/{order}/items', [DepotofficerController::class, 'orderItemsList'])->name('order.items');

    // confirm arrival of the batch
    Route::post('/allocation/{allocation}/arrive', [DepotofficerController::class, 'confirmArrival'])->name('allocation.arrive');

    // Intake Management (Checking/Flagging incoming custom stock)
    Route::get('/intake', [DepotofficerController::class, 'intakeList'])->name('intake.index');
    Route::post('/intake/{item}/damage', [DepotofficerController::class, 'flagDamage'])->name('intake.damage');

    // Live Verification Scanning & Lookups
    Route::get('/verify', [DepotofficerController::class, 'verifyLookup'])->name('verify.lookup');
    Route::post('/verify/collect', [DepotofficerController::class, 'processCollection'])->name('verify.collect');

    // List of Users Who Paid
    Route::get('/list-of-users-who-paid', [DepotofficerController::class, 'listOfUsersWhoPaid'])->name('listOfUsersWhoPaid');
    Route::get('/orders/{order}/receipt', [DepotofficerController::class, 'showOrderReceipt'])->name('orders.receipt');
    
        
});



// --- ADMIN ROUTES (Consolidated) ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    
    // --- THIS WAS MISSING ---
    // This creates the route 'admin.dashboard'
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // --- USER MANAGEMENT ---
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // allocation
    // List of Products (Index)
    Route::get('/allocations', [AllocationController::class, 'index'])->name('allocations.index');

    // Create Form (Must be ABOVE the {product_name} route)
    Route::get('/allocations/create', [AllocationController::class, 'create'])->name('allocations.create');
    
    // The Store Logic
    Route::post('/allocations', [AllocationController::class, 'store'])->name('allocations.store');

    // The Detail Page (Dynamic parameter at the end)
    Route::get('/allocations/{batch}', [AllocationController::class, 'show'])->name('allocations.show');
    Route::delete('/allocations/{batch}', [AllocationController::class, 'destroy'])->name('allocations.destroy');

    // Dispatch & Tag Printing Console
    Route::get('/dispatch', [AllocationController::class, 'dispatchStates'])->name('dispatch.states');
    Route::get('/dispatch/state/{state}', [AllocationController::class, 'dispatchStateOrders'])->name('dispatch.state.orders');

    // Admin Global Order Console
    Route::get('/orders', [AdminDashboardController::class, 'globalOrdersIndex'])->name('orders.index');
    Route::get('/orders/{order}', [AdminDashboardController::class, 'globalOrderShow'])->name('orders.show');

    // Admin Incident Management Desk
    Route::get('/incidents', [AdminDashboardController::class, 'globalIncidentsIndex'])->name('incidents.index');
    Route::post('/incidents/{item}/resolve', [AdminDashboardController::class, 'resolveIncident'])->name('incidents.resolve');

});


// --- PROFILE ROUTES ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// -----PUBLIC ROUTE ------
// Completely public - no login, no role checks

// Route::prefix('public')->name('public.')->group(function () {

//     // The "Landing" page with the input field
//     Route::get('/verify', [PublicVerificationController::class, 'index'])->name('verify');
    
//     // The logic that handles the manual tag input
//     Route::post('/search', [PublicVerificationController::class, 'search'])->name('search');
    
//     // The Passport (already created)
//     Route::get('/passport/{tag_number}', [PublicVerificationController::class, 'showPassport'])->name('item.passport');

//     // The Anonymous Report Handler
//     Route::post('/report/{itemId}', [PublicVerificationController::class, 'submitAnonymousReport'])
//         ->name('report.submit');
// });


// External Webhook Listener for paystack (No Auth Middleware, No CSRF)
Route::post('/api/paystack/webhook', [App\Http\Controllers\WebhookController::class, 'handlePaystack']);

require __DIR__.'/auth.php';