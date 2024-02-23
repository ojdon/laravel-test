<div class="flex flex-row items-center space-x-4">
    <div>
        <label for="quantity" class="block">Quantity:</label>
        <input type="number" wire:model.live="quantity" id="quantity" name="quantity" class="border rounded-md px-2 py-1" min="1">
    </div>
    <div>
        <label for="unit_cost" class="block">Unit Cost (&pound;):</label>
        <input type="number" wire:model.live="unitCost" id="unit_cost" name="unit_cost" class="border rounded-md px-2 py-1" min="1">
    </div>
    <div>
        <p class="font-bold">
            Selling Price:
            <span class="block"> &pound; {{$sellingPrice ?? '0.00'}} </span>
        </p>
    </div>
    <div>
        <button wire:click="recordSale" class="bg-green-500 text-white px-4 py-2 rounded-md">Record Sale</button>
    </div>
</div>
