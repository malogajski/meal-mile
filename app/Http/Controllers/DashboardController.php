<?php

namespace App\Http\Controllers;

use App\Models\ShoppingList;
use App\Models\ShoppingListItem;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate the total number of shopping lists
        $totalLists = ShoppingList::count();

        // Calculate the total number of items across all lists
        $totalItems = ShoppingListItem::count();

        // Find the most frequently purchased item
        // This query selects item IDs and counts how many times each appears,
        // grouping by item_id and ordering by the count in descending order to get the most frequent item.
        $mostFrequentItem = ShoppingListItem::select('item_id', DB::raw('count(*) as count'))
            ->groupBy('item_id')
            ->orderBy('count', 'DESC')
            ->first();

        // If there is at least one item, find its name. Otherwise, set default values.
        if ($mostFrequentItem) {
            $mostFrequentItemName = Item::where('id', $mostFrequentItem->item_id)->first()->name;
        } else {
            $mostFrequentItemName = "N/A"; // Default value if there are no items
            $mostFrequentItem = (object)['count' => 0]; // Create an object with a count of 0 for consistency
        }

        // Calculate the average number of items per list
        // This is done by dividing the total number of items by the total number of lists,
        // with a check to ensure there is no division by zero.
        $avgItemsPerList = $totalLists > 0 ? round($totalItems / $totalLists, 2) : 0;

        // Pass the calculated data to the dashboard view
        // compact() is a PHP function that creates an array from existing variables.
        return view('dashboard', compact('totalLists', 'totalItems', 'mostFrequentItemName', 'mostFrequentItem', 'avgItemsPerList'));
    }
}
