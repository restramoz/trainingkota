<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingSchedule;
use App\Models\Service;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');

        $schedules = TrainingSchedule::with(['service', 'city'])
            ->when($search, function ($query) use ($search) {
                $query->whereFunction('lower', 'location', 'like', "%".strtolower($search)."%")
                      ->orWhereHas('service', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      })
                      ->orWhereHas('city', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->orderBy('date', 'asc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $services = Service::where('category', 'pelatihan')->orderBy('name')->get();
        $cities = City::orderBy('name')->get();

        return view('admin.schedules.create', compact('services', 'cities'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        TrainingSchedule::create($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal pelatihan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $schedule = TrainingSchedule::with(['service', 'city'])->findOrFail($id);

        return view('admin.schedules.show', compact('schedule'));
    }

    public function edit($id)
    {
        $schedule = TrainingSchedule::findOrFail($id);
        $services = Service::where('category', 'pelatihan')->orderBy('name')->get();
        $cities = City::orderBy('name')->get();

        return view('admin.schedules.edit', compact('schedule', 'services', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $schedule = TrainingSchedule::findOrFail($id);
        $validated = $this->validateRequest($request);

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal pelatihan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $schedule = TrainingSchedule::findOrFail($id);
        $name = $schedule->service->name;
        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', "Jadwal '{$name}' berhasil dihapus.");
    }

    protected function validateRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'city_id' => 'required|exists:cities,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
            'available_slots' => 'required|integer|min:1',
            'status' => 'required|in:open,closed,completed',
            'notes' => 'nullable|string',
        ])->validate();
    }
}
