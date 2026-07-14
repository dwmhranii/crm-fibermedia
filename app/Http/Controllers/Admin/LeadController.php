<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Coverage;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $status = $request->get('status', '');
        $withTrashed = (bool) $request->get('trashed', false);

        $query = Lead::query()
            ->with(['coverage:id,name', 'package:id,name', 'handler:id,name'])
            ->when($q, function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('phone', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%")
                      ->orWhere('source', 'like', "%{$q}%");
                });
            })
            ->when($status, fn ($qq) => $qq->where('status', $status))
            ->latest();

        if ($withTrashed) {
            $query->withTrashed();
        }

        $leads = $query->paginate(12)->withQueryString();

        return view('admin.leads.index', [
            'leads' => $leads,
            'q' => $q,
            'status' => $status,
            'statusOptions' => Lead::statusOptions(),
            'withTrashed' => $withTrashed,
        ]);
    }

    public function show(Lead $lead)
    {
        $lead->load(['coverage:id,name', 'package:id,name', 'handler:id,name']);

        return view('admin.leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        $coverages = Coverage::query()->select('id', 'name')->orderBy('name')->get();
        $packages  = Package::query()->select('id', 'name')->orderBy('name')->get();

        return view('admin.leads.edit', [
            'lead' => $lead,
            'coverages' => $coverages,
            'packages' => $packages,
            'statusOptions' => Lead::statusOptions(),
        ]);
    }

    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:191'],
            'address' => ['nullable', 'string', 'max:255'],
            'coverage_id' => ['nullable', 'integer', 'exists:coverages,id'],
            'package_id' => ['nullable', 'integer', 'exists:packages,id'],
            'message' => ['nullable', 'string'],
            'source' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:new,contacted,closed,spam'],
            'set_handled' => ['nullable', 'boolean'],
        ]);

        // checkbox helper
        $setHandled = (bool) ($data['set_handled'] ?? false);
        unset($data['set_handled']);

        $lead->fill($data);

        if ($setHandled) {
            $lead->markHandled(Auth::id());
        } else {
            // kalau status balik ke 'new', optional: reset handled info
            // kalau tidak mau, hapus blok ini
            if ($lead->status === Lead::STATUS_NEW) {
                $lead->handled_by = null;
                $lead->handled_at = null;
            }
        }

        $lead->save();

        return redirect()
            ->route('admin.leads.show', $lead)
            ->with('success', 'Lead berhasil diupdate.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()
            ->route('admin.leads.index')
            ->with('success', 'Lead berhasil dihapus.');
    }

    // Optional: restore soft deleted lead
    public function restore($id)
    {
        $lead = Lead::withTrashed()->findOrFail($id);
        $lead->restore();

        return redirect()
            ->route('admin.leads.index', ['trashed' => 1])
            ->with('success', 'Lead berhasil direstore.');
    }
}
