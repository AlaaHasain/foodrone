<h4 class="mb-4">Top Selling Dishes</h4>

@if ($topSellingDishes->count())
<table>
    <thead>
        <tr>
            <th>Dish</th>
            <th>Sales</th>
        </tr>
    </thead>
    <tbody>
        @foreach($topSellingDishes as $dish)
        <tr>
            <td>{{ $dish->name }}</td>
            <td>{{ $dish->total_sold }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
    <p class="text-muted">No sales data available.</p>
@endif
