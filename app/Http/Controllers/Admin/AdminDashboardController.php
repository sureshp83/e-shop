<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    //

    public function showDashboard()
    {
        $graphData = [
            [
                'x' => 'Product 1',
                'y' => 3,
                'z' => 10
            ],
            [
                'x' => 'Product 2',
                'y' => 5,
                'z' => 7
            ],
            [
                'x' => 'Product 3',
                'y' => 6,
                'z' => 15
            ],
            [
                'x' => 'Product 4',
                'y' => 2,
                'z' => 6
            ]
        ];
        $graphData = json_encode($graphData);

        return view('admin.dashboard', compact('graphData'));
    }
}
