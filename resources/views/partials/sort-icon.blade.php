@if ($sortBy !== $field)
    <i class="text-muted fa-solid fa-sort"></i>
@elseif($sortDirection == 'asc')
    <i class="fa-solid fa-sort-up"></i>
@else
    <i class="fa-solid fa-sort-down"></i>
@endif