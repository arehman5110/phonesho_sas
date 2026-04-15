<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRepairRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    // -----------------------------------------------
    // Rules
    // -----------------------------------------------
    public function rules(): array
    {
        return [
            // Customer — optional
            'customer_id' => ['nullable', 'exists:customers,id'],

            // Repair details
            'status_id' => ['required', 'exists:statuses,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'book_in_date' => ['nullable', 'date'],
            'completion_date' => ['nullable', 'date'],
            'delivery_type' => ['required', 'in:collection,delivery'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:2000'],

            // Devices — at least one required
            'devices' => ['required', 'array', 'min:1'],
            'devices.*.device_name' => ['required', 'string', 'max:255'],
            'devices.*.device_type_id' => ['nullable', 'exists:device_types,id'],
            'devices.*.imei' => ['nullable', 'string', 'max:100'],
            'devices.*.color' => ['nullable', 'string', 'max:50'],
            'devices.*.repair_type' => ['nullable', 'string', 'max:255'],
            'devices.*.notes' => ['nullable', 'string', 'max:2000'],
            'devices.*.warranty_status' => ['nullable', 'in:none,active,expired'],
'devices.*.warranty_days'   => ['nullable', 'integer', 'min:0'],
            'devices.*.price' => ['nullable', 'numeric', 'min:0'],

            // Issues (array of labels)
            'devices.*.issues' => ['nullable', 'array'],
            'devices.*.issues.*.label' => ['nullable', 'string', 'max:255'],

            // Parts (optional)
            'devices.*.parts' => ['nullable', 'array'],
            'devices.*.parts.*.name' => ['required_with:devices.*.parts', 'string', 'max:255'],
            'devices.*.parts.*.product_id' => ['nullable', 'exists:products,id'],
            'devices.*.parts.*.quantity' => ['nullable', 'integer', 'min:1'],

            // Payments (optional)
            'payments' => ['nullable', 'array'],
            'payments.*.method' => ['required_with:payments', 'in:cash,card,split,trade,other'],
            'payments.*.amount' => ['required_with:payments', 'numeric', 'min:0.01'],
            'payments.*.split_part' => ['nullable', 'string'],
            'payments.*.note' => ['nullable', 'string', 'max:500'],

            'devices.*.repair_type'       => ['nullable', 'string', 'max:255'],
'devices.*.repair_types'      => ['nullable', 'array'],
'devices.*.repair_types.*'    => ['nullable', 'string', 'max:255'],
            'devices.*.warranty_days' => ['nullable', 'integer', 'min:0', 'max:3650'],
            'devices.*.status_id' => ['nullable', 'exists:statuses,id'],
        ];
    }

    // -----------------------------------------------
    // Messages
    // -----------------------------------------------
    public function messages(): array
    {
        return [
            'devices.required' => 'Please add at least one device.',
            'devices.min' => 'Please add at least one device.',
            'devices.*.device_name.required' => 'Device name is required.',
            'devices.*.warranty_status.required' => 'Warranty status is required.',
            'status_id.required' => 'Please select a status.',
            'delivery_type.required' => 'Please select a delivery type.',
        ];
    }

    // -----------------------------------------------
    // After validation — business rules
    // -----------------------------------------------
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $data = $this->validated();

            // Validate payments if provided
            if (!empty($data['payments'])) {
                $this->_validatePayments($validator, $data['payments'], $data);
            }
        });
    }

    // -----------------------------------------------
    // Validate payment totals
    // -----------------------------------------------
    private function _validatePayments(Validator $validator, array $payments, array $data): void
    {
        // Calculate total price
        $totalPrice = collect($data['devices'] ?? [])->sum(fn($d) => (float) ($d['price'] ?? 0));

        $discount = (float) ($data['discount'] ?? 0);
        $finalPrice = max(0, $totalPrice - $discount);

        // Sum payments
        $totalPaid = collect($payments)->sum(fn($p) => (float) ($p['amount'] ?? 0));

        // Payments cannot exceed total
        if ($totalPaid > $finalPrice && $finalPrice > 0) {
            $validator->errors()->add('payments', 'Total payments (' . '£' . number_format($totalPaid, 2) . ') ' . 'cannot exceed repair total (' . '£' . number_format($finalPrice, 2) . ').');
        }
    }

    // -----------------------------------------------
    // Return JSON for AJAX
    // -----------------------------------------------
    protected function failedValidation(Validator $validator): void
    {
        if ($this->expectsJson() || $this->ajax()) {
            throw new HttpResponseException(
                response()->json(
                    [
                        'success' => false,
                        'message' => 'Validation failed.',
                        'errors' => $validator->errors(),
                    ],
                    422,
                ),
            );
        }

        parent::failedValidation($validator);
    }
}
