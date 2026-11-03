<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create
                            {--email= : Alamat email admin}
                            {--name= : Nama admin}
                            {--password= : Password akun admin}
                            {--demo : Gunakan variabel konfigurasi dari .env}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat atau memperbarui akun administrator secara aman';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // 1. Verifikasi koneksi database target
        try {
            DB::connection()->getPdo();
            $connectionName = config('database.default');
            $databaseName = config("database.connections.{$connectionName}.database");
            $this->comment("Database target terverifikasi: [{$connectionName}] {$databaseName}");
        } catch (\Throwable $e) {
            $this->error('Gagal terhubung ke database target: '.$e->getMessage());

            return Command::FAILURE;
        }

        // 2. Ambil nilai email, nama, dan password
        $email = $this->option('email') ?: config('admin.demo.email');
        $name = $this->option('name') ?: (config('admin.demo.name') ?: 'Administrator');
        $password = $this->option('password') ?: config('admin.demo.password');

        // Jika email kosong, minta secara interaktif bila memungkinkan
        if (empty($email) && $this->input->isInteractive()) {
            $email = $this->ask('Masukkan email admin');
        }

        if (empty($email)) {
            $this->error('Gagal: ADMIN_EMAIL wajib diisi di .env atau diberikan melalui opsi --email.');

            return Command::FAILURE;
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error("Format email [{$email}] tidak valid.");

            return Command::FAILURE;
        }

        // Jika password kosong, minta secara interaktif jika sesi CLI mengizinkan
        if (empty($password) && $this->input->isInteractive()) {
            $password = $this->secret('Masukkan password admin (input tersembunyi)');
        }

        if (empty($password)) {
            $this->error('Gagal: ADMIN_PASSWORD atau opsi --password belum diisi. Demi keamanan, password default tidak diaktifkan secara otomatis.');

            return Command::FAILURE;
        }

        if (strlen((string) $password) < 8) {
            $this->error('Password minimal 8 karakter demi keamanan akun admin.');

            return Command::FAILURE;
        }

        // 3. Simpan atau perbarui akun tanpa menduplikasi data atau menurunkan hak akses
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->name = $name ?: $user->name;
            $user->password = Hash::make($password);
            $user->is_admin = true;
            $user->save();

            $this->info("Akun admin [{$email}] berhasil diperbarui dan dipastikan memiliki status admin aktif.");
        } else {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'is_admin' => true,
            ]);

            $this->info("Akun admin baru [{$email}] berhasil dibuat dengan status admin aktif.");
        }

        return Command::SUCCESS;
    }
}
