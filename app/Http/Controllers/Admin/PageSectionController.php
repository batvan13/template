<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use Illuminate\Http\Request;

class PageSectionController extends Controller
{
    public function index()
    {
        $sections = PageSection::query()
            ->orderBy('page')
            ->orderBy('section')
            ->get();

        return view('admin.sections.index', compact('sections'));
    }

    public function edit(PageSection $pageSection)
    {
        return view('admin.sections.edit', compact('pageSection'));
    }

    public function update(Request $request, PageSection $pageSection)
    {
        $validated = $request->validate([
            'title'            => ['nullable', 'string', 'max:255'],
            'subtitle'         => ['nullable', 'string', 'max:255'],
            'content'          => ['nullable', 'string'],
            'meta.button_text' => ['nullable', 'string', 'max:255'],
            'meta.button_url'  => ['nullable', 'string', 'max:255'],
        ]);

        $pageSection->update([
            'title'    => $validated['title']    ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'content'  => $validated['content']  ?? null,
            'meta'     => [
                'button_text' => $validated['meta']['button_text'] ?? null,
                'button_url'  => $validated['meta']['button_url']  ?? null,
            ],
        ]);

        return redirect()
            ->route('admin.sections.edit', $pageSection)
            ->with('success', 'Секцията беше обновена успешно.');
    }
}
