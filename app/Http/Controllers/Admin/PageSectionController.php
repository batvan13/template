<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PageSectionController extends Controller
{
    public function index()
    {
        $sections = PageSection::query()
            ->orderBy('page')
            ->orderBy('section')
            ->get()
            ->reject(fn (PageSection $section) => ($section->page === 'home' && $section->section === 'faq')
                || ($section->page === 'home' && $section->section === 'gallery_preview')
                || $section->page === 'gallery')
            ->values();

        return view('admin.sections.index', compact('sections'));
    }

    public function edit(PageSection $pageSection)
    {
        return view('admin.sections.edit', compact('pageSection'));
    }

    public function update(Request $request, PageSection $pageSection)
    {
        if ($this->isHomeFaqSection($pageSection)) {
            $validated = $request->validate([
                'title'            => ['nullable', 'string', 'max:255'],
                'faq'              => ['nullable', 'array'],
                'faq.*.question'   => ['nullable', 'string', 'max:2000'],
                'faq.*.answer'     => ['nullable', 'string', 'max:20000'],
            ]);

            $titleRaw = $validated['title'] ?? null;
            $title = ($titleRaw === null || trim((string) $titleRaw) === '')
                ? null
                : trim((string) $titleRaw);

            $pageSection->update([
                'title' => $title,
                'faq' => $this->normalizeFaqForPersistence($request->input('faq')),
            ]);
        } else {
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
        }

        return redirect()
            ->route('admin.sections.edit', $pageSection)
            ->with('success', 'Секцията беше обновена успешно.');
    }

    private function isHomeFaqSection(PageSection $pageSection): bool
    {
        return $pageSection->page === 'home' && $pageSection->section === 'faq';
    }

    /**
     * @return list<array{question: string, answer: string}>|null
     */
    private function normalizeFaqForPersistence(mixed $faq): ?array
    {
        if (! is_array($faq)) {
            return null;
        }

        $items = [];
        foreach ($faq as $row) {
            if (! is_array($row)) {
                continue;
            }
            $question = trim((string) ($row['question'] ?? ''));
            $answer = trim((string) ($row['answer'] ?? ''));

            if ($question === '' && $answer === '') {
                continue;
            }

            if ($question === '' || $answer === '') {
                throw ValidationException::withMessages([
                    'faq' => [
                        'Всеки ред с попълнено поле трябва да има и въпрос, и отговор. Изтрий текста от едното поле или допълни другото.',
                    ],
                ]);
            }

            $items[] = [
                'question' => $question,
                'answer' => $answer,
            ];
        }

        return $items === [] ? null : $items;
    }
}
