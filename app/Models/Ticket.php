<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'name',
        'company',
        'phone',
        'email',
        'category',
        'service_id',
        'city_id',
        'subject',
        'message',
        'status',
        'priority',
        'notes',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Generate official WhatsApp redirect URL for this ticket.
     */
    public function getWhatsAppUrl(): string
    {
        $officialWa = config('contact.whatsapp', '628118500177');
        $serviceName = $this->service ? $this->service->name : ($this->category ? ucfirst($this->category) : 'Layanan K3');
        $cityName = $this->city ? $this->city->name : 'Nasional';

        $text = "Halo Admin TrainingKota,\n\n"
              . "Follow up Tiket Resmi: #{$this->ticket_number}\n"
              . "Nama Klien: {$this->name}\n"
              . ($this->company ? "Perusahaan: {$this->company}\n" : "")
              . "Kontak WhatsApp: {$this->phone}\n"
              . "Kebutuhan: {$serviceName}\n"
              . "Wilayah: {$cityName}\n"
              . "Subjek: {$this->subject}\n"
              . "Pesan: {$this->message}\n\n"
              . "Mohon asistensi lebih lanjut.";

        return "https://wa.me/{$officialWa}?text=" . rawurlencode($text);
    }

    /**
     * Generate WhatsApp link to directly chat with the customer.
     */
    public function getCustomerWhatsAppUrl(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $serviceName = $this->service ? $this->service->name : 'Layanan K3';
        $cityName = $this->city ? $this->city->name : '';

        $text = "Halo Bapak/Ibu {$this->name},\n\n"
              . "Terima kasih telah menghubungi TrainingKota terkait konsultasi {$serviceName}" . ($cityName ? " di {$cityName}" : "") . ".\n"
              . "Kami menindaklanjuti tiket permohonan #{$this->ticket_number}. Apakah ada informasi spesifik mengenai jadwal dan kebutuhan perusahaan yang dapat kami bantu?";

        return "https://wa.me/{$phone}?text=" . rawurlencode($text);
    }
}
