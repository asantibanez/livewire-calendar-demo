<?php

namespace App\Http\Livewire;

use App\Appointment;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AppointmentsCalendar extends LivewireCalendar
{
    public $isModalOpen = false;

    public $selectedAppointment = null;

    public $newAppointment;

    public function events(): Collection
    {
        return Appointment::query()
            ->whereDate('scheduled_at', '>=', $this->gridStartsAt)
            ->whereDate('scheduled_at', '<=', $this->gridEndsAt)
            ->get()
            ->map(function (Appointment $appointment) {
                return [
                    'id' => $appointment->id,
                    'title' => $appointment->title,
                    'description' => $appointment->notes,
                    'date' => $appointment->scheduled_at,
                ];
            });
    }

    public function unscheduledEvents() : Collection
    {
        return Appointment::query()
            ->whereNull('scheduled_at')
            ->get();
    }

    public function onDayClick($year, $month, $day)
    {
        $this->isModalOpen = true;

        $this->resetNewAppointment();

        $this->newAppointment['scheduled_at'] = Carbon::today()
            ->setDate($year, $month, $day)
            ->format('Y-m-d');
    }

    public function saveAppointment()
    {
        Appointment::create($this->newAppointment);

        $this->isModalOpen = false;
    }

    public function onEventDropped($eventId, $year, $month, $day)
    {
        $appointment = Appointment::find($eventId);
        $appointment->scheduled_at = Carbon::today()->setDate($year, $month, $day);
        $appointment->save();
    }

    private function resetNewAppointment()
    {
        $this->newAppointment = [
            'title' => '',
            'notes' => '',
            'scheduled_at' => '',
            'priority' => 'normal',
        ];
    }

    public function onEventClick($eventId)
    {
        $this->selectedAppointment = Appointment::find($eventId);
    }

    public function unscheduleAppointment()
    {
        $appointment = Appointment::find($this->selectedAppointment['id']);
        $appointment->scheduled_at = null;
        $appointment->save();

        $this->selectedAppointment = null;
    }

    public function closeAppointmentDetailsModal()
    {
        $this->selectedAppointment = null;
    }

    public function render()
    {
        return parent::render()->with([
            'unscheduledEvents' => $this->unscheduledEvents()
        ]);
    }
}
