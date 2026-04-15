<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Product;

class StoreSaleRequest extends FormRequest
{
    // -----------------------------------------------
    // Authorization
    // -----------------------------------------------
    public function authorize(): bool
    {
        return auth()->check();
    }

    // -----------------------------------------------
    // Validation Rules
    // -----------------------------------------------
    public function rules(): array
    {
        return [
            // Customer (optional)
            'customer_id'            => ['nullable', 'exists:customers,id'],

            // Payment method
            'payment_method'         => ['required', 'in:cash,card,split,trade,other'],

            // Discount
            'discount'               => ['nullable', 'numeric', 'min:0'],

            // Notes
            'notes'                  => ['nullable', 'string', 'max:500'],

            // Items — at least one required
            'items'                  => ['required_without:custom_items', 'array'],
            'items.*.product_id'     => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity'       => ['required', 'integer', 'min:1'],
            'items.*.price'          => ['required', 'numeric', 'min:0'],

            // Custom items (no product_id needed)
            'custom_items'           => ['nullable', 'array'],
            'custom_items.*.name'    => ['required', 'string', 'max:255'],
            'custom_items.*.price'   => ['required', 'numeric', 'min:0'],
            'custom_items.*.quantity'=> ['required', 'integer', 'min:1'],

            // Split payment fields
            'split_cash'             => ['nullable', 'numeric', 'min:0'],
            'split_card'             => ['nullable', 'numeric', 'min:0'],
            'split1_method'          => ['nullable', 'in:cash,card,trade,other'],
            'split2_method'          => ['nullable', 'in:cash,card,trade,other'],
            'split1_note'            => ['nullable', 'string', 'max:255'],
            'split2_note'            => ['nullable', 'string', 'max:255'],

            // Trade-in fields
            'trade_value'            => ['nullable', 'numeric', 'min:0'],
            'trade_device'           => ['nullable', 'string', 'max:255'],
        ];
    }

    // -----------------------------------------------
    // Custom Messages
    // -----------------------------------------------
    public function messages(): array
    {
        return [
            'items.required_without'      => 'Please add at least one item to the sale.',
            'items.*.product_id.required' => 'Each item must have a product selected.',
            'items.*.product_id.exists'   => 'One or more selected products do not exist.',
            'items.*.quantity.required'   => 'Each item must have a quantity.',
            'items.*.quantity.min'        => 'Quantity must be at least 1.',
            'items.*.price.required'      => 'Each item must have a price.',
            'items.*.price.min'           => 'Price cannot be negative.',
            'payment_method.required'     => 'Please select a payment method.',
            'payment_method.in'           => 'Invalid payment method selected.',
            'custom_items.*.name.required'=> 'Custom item must have a name.',
            'custom_items.*.price.min'    => 'Custom item price cannot be negative.',
        ];
    }

    // -----------------------------------------------
    // Custom Attribute Names
    // -----------------------------------------------
    public function attributes(): array
    {
        return [
            'items.*.product_id' => 'product',
            'items.*.quantity'   => 'quantity',
            'items.*.price'      => 'price',
            'customer_id'        => 'customer',
            'payment_method'     => 'payment method',
        ];
    }

    // -----------------------------------------------
    // After Validation Hook
    // -----------------------------------------------
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {

            // Skip if basic validation already failed
            if ($validator->errors()->isNotEmpty()) return;

            $shopId = auth()->user()->active_shop_id;
            $data   = $this->validated();

            // ── Validate items exist ──────────────────────────
            if (!empty($data['items'])) {
                $this->_validateItems(
                    $validator,
                    $data['items'],
                    $shopId
                );
            }

            // ── Validate totals ───────────────────────────────
            if ($validator->errors()->isEmpty()) {
                $this->_validatePaymentAmounts(
                    $validator,
                    $data
                );
            }
        });
    }

    // -----------------------------------------------
    // Validate product stock & shop ownership
    // -----------------------------------------------
    private function _validateItems(
        Validator $validator,
        array     $items,
        int       $shopId
    ): void {
        // Group by product_id to handle duplicates
        $grouped = collect($items)->groupBy('product_id');

        foreach ($grouped as $productId => $productItems) {

            $product = Product::where('shop_id', $shopId)
                               ->where('is_active', true)
                               ->find($productId);

            if (!$product) {
                $validator->errors()->add(
                    'items',
                    "Product ID {$productId} not found in this shop."
                );
                continue;
            }

            // Note: We allow selling out-of-stock items
            // Stock will go negative — by design for repair shops
        }
    }

    // -----------------------------------------------
    // Validate payment amounts match totals
    // -----------------------------------------------
  private function _validatePaymentAmounts(
    Validator $validator,
    array     $data
): void {
    $method = $data['payment_method'] ?? 'cash';

    // Calculate final amount
    $totalAmount = 0;

    if (!empty($data['items'])) {
        $totalAmount += collect($data['items'])
            ->sum(fn($i) => $i['quantity'] * $i['price']);
    }

    if (!empty($data['custom_items'])) {
        $totalAmount += collect($data['custom_items'])
            ->sum(fn($i) => ($i['quantity'] ?? 1) * $i['price']);
    }

    $discount    = (float) ($data['discount'] ?? 0);
    $finalAmount = max(0, $totalAmount - $discount);

    // Validate discount doesn't exceed total
    if ($discount > $totalAmount) {
        $validator->errors()->add(
            'discount',
            'Discount cannot exceed the total amount.'
        );
        return;
    }

    // Validate split amounts
    // Use split1Amount + split2Amount regardless of method selected
    if ($method === 'split') {
        $split1 = (float) ($data['split_cash'] ?? 0);
        $split2 = (float) ($data['split_card'] ?? 0);
        $splitTotal = $split1 + $split2;

        if ($splitTotal <= 0) {
            $validator->errors()->add(
                'split_cash',
                'Please enter at least one split payment amount.'
            );
            return;
        }

        if (round($splitTotal, 2) > round($finalAmount, 2)) {
            $validator->errors()->add(
                'split_cash',
                "Split total (£" . number_format($splitTotal, 2) . ") "
                . "cannot exceed sale total (£" . number_format($finalAmount, 2) . ")."
            );
        }
    }

    // Validate trade value
    if ($method === 'trade') {
        $tradeValue = (float) ($data['trade_value'] ?? 0);
        if ($tradeValue <= 0) {
            $validator->errors()->add(
                'trade_value',
                'Please enter a trade-in value.'
            );
        }
    }
}

    // -----------------------------------------------
    // Return JSON for AJAX requests
    // -----------------------------------------------
    protected function failedValidation(Validator $validator): void
    {
        if ($this->expectsJson() || $this->ajax()) {
            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors'  => $validator->errors(),
                ], 422)
            );
        }

        parent::failedValidation($validator);
    }
}