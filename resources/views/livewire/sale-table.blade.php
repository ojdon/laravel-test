<div>
    @if($sales->isEmpty())
        <p class="text-gray-500">No sales recorded. Please enter using the form above to record a sale.</p>
    @else
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                <tr class="bg-blue-500 text-white text-left">
                    <th class="sticky top-0 px-4 py-2">Quantity</th>
                    <th class="sticky top-0 px-4 py-2">Unit Cost</th>
                    <th class="sticky top-0 px-4 py-2">Selling Price</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sales as $sale)
                    <tr class="{{ $loop->odd ? 'bg-blue-200' : 'bg-white' }}">
                        <td class="px-4 py-2">{{ $sale->quantity }}</td>
                        <td class="px-4 py-2">£{{ $sale->unit_cost }}</td>
                        <td class="px-4 py-2">£{{ $sale->selling_price }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
