<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
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
            'totalSections'  => PageSection::count(),
            'totalSettings'  => SiteSetting::count(),
            'totalGallery'   => GalleryItem::count(),
            'activeGallery'  => GalleryItem::where('is_active', true)->count(),
        ]);
    }
}
