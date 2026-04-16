 (cd "$(git rev-parse --show-toplevel)" && git apply --3way <<'EOF' 
diff --git a/app/Http/Controllers/CustomerController.php b/app/Http/Controllers/CustomerController.php
index 50228cd80622338bc93706bf121f059c40de6ca1..a1cc09f06e9780d6c06b5d4841a965b2fb2f83fa 100644
--- a/app/Http/Controllers/CustomerController.php
+++ b/app/Http/Controllers/CustomerController.php
@@ -1,35 +1,81 @@
 <?php
 
 namespace App\Http\Controllers;
 
 use App\Models\Customer;
 use Illuminate\Http\Request;
 use Illuminate\Http\JsonResponse;
 
 class CustomerController extends Controller
 {
+    // -----------------------------------------------
+    // GET /customers
+    // -----------------------------------------------
+    public function index(Request $request)
+    {
+        $shopId  = auth()->user()->active_shop_id;
+        $search  = trim((string) $request->input('search', ''));
+
+        $customers = Customer::forShop($shopId)
+            ->withCount(['repairs', 'sales'])
+            ->withSum('repairs', 'final_price')
+            ->withSum('sales', 'final_amount')
+            ->when($search !== '', fn($query) => $query->search($search))
+            ->orderBy('name')
+            ->paginate(20)
+            ->withQueryString();
+
+        return view('customers.index', compact('customers', 'search'));
+    }
+
+    // -----------------------------------------------
+    // GET /customers/{customer}
+    // -----------------------------------------------
+    public function show(Customer $customer)
+    {
+        abort_if($customer->shop_id !== auth()->user()->active_shop_id, 403);
+
+        $customer->load([
+            'repairs' => fn($query) => $query
+                ->latest()
+                ->limit(20)
+                ->with(['status:id,name,color']),
+            'sales' => fn($query) => $query->latest()->limit(20),
+        ]);
+
+        $summary = [
+            'total_repairs'       => $customer->repairs()->count(),
+            'total_repair_value'  => (float) $customer->repairs()->sum('final_price'),
+            'total_sales'         => $customer->sales()->count(),
+            'total_sales_value'   => (float) $customer->sales()->sum('final_amount'),
+            'total_spent'         => (float) ($customer->repairs()->sum('final_price') + $customer->sales()->sum('final_amount')),
+        ];
+
+        return view('customers.show', compact('customer', 'summary'));
+    }
+
     // -----------------------------------------------
     // GET /api/customers/search
     // -----------------------------------------------
     public function search(Request $request): JsonResponse
     {
         $shopId = auth()->user()->active_shop_id;
         $term   = $request->input('q', '');
 
         $customers = Customer::where('shop_id', $shopId)
             ->when($term, fn($q) =>
                 $q->where('name',  'like', "%{$term}%")
                   ->orWhere('phone', 'like', "%{$term}%")
                   ->orWhere('email', 'like', "%{$term}%")
             )
             ->orderBy('name')
             ->limit(10)
             ->get();
 
         return response()->json(
             $customers->map(fn($c) => $this->_format($c))
         );
     }
 
     // -----------------------------------------------
     // GET /api/customers/{customer}/stats
@@ -96,26 +142,26 @@ public function update(Request $request, Customer $customer): JsonResponse
         ]);
 
         $customer->update($validated);
 
         return response()->json([
             'success'  => true,
             'message'  => "Customer \"{$customer->name}\" updated!",
             'customer' => $this->_format($customer),
         ]);
     }
 
     // -----------------------------------------------
     // Format customer for JSON
     // -----------------------------------------------
     private function _format(Customer $customer): array
     {
         return [
             'id'      => $customer->id,
             'name'    => $customer->name,
             'phone'   => $customer->phone,
             'email'   => $customer->email,
             'address' => $customer->address,
             'notes'   => $customer->notes,
         ];
     }
-}
\ No newline at end of file
+}
 
EOF
)