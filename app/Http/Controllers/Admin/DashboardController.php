<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use App\Models\Service;
use App\Models\SiteSetting;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalServices'  => Service::count(),
            'activeServices' => Service::where('is_active', true)->count(),
            'totalSections'  => PageSection::query()
                ->where('page', '!=', 'gallery')
                ->whereNot(fn ($q) => $q->where('page', 'home')->where('section', 'faq'))
                ->whereNot(fn ($q) => $q->where('page', 'home')->where('section', 'gallery_preview'))
                ->count(),
            'totalSettings'  => SiteSetting::count(),
        ]);
    }
}
