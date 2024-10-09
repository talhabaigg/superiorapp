<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\MaterialItem;
use Illuminate\Http\Request;

class RequisitionController extends Controller
{
    public function create() {
        $suppliers = MaterialItem::groupBy('supplier_name')->pluck('supplier_name', 'supplier_name');
        // dd($suppliers);
        $projects_completed = Project::where('completed', 1)->get();
    $projects_active = Project::where('completed', 0)->get();
    
        $items = MaterialItem::all();
        return Inertia('Requisition/Create', ['items' => $items, 'suppliers' => $suppliers, 'projects_completed' => $projects_completed,
        'projects_active' => $projects_active,]);
    }
}
