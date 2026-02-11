<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

class InstallController extends Controller
{
    public function run(Request $request)
    {
        $token = (string) env('INSTALL_TOKEN', '');
        $provided = (string) $request->query('token', '');

        if ($token === '') {
            return response(
                "INSTALL_TOKEN is not set.\n".
                "Add INSTALL_TOKEN=some-long-random-string to your .env, then open:\n".
                "/api/_install?token=YOUR_TOKEN\n",
                500
            )->header('Content-Type', 'text/plain; charset=UTF-8');
        }

        if (!hash_equals($token, $provided)) {
            return response("Forbidden.\n", 403)->header('Content-Type', 'text/plain; charset=UTF-8');
        }

        $lockPath = storage_path('app/install.lock');
        if (is_file($lockPath)) {
            return response(
                "Already installed (lock file exists).\n".
                "If you truly need to re-run, delete: storage/app/install.lock\n",
                409
            )->header('Content-Type', 'text/plain; charset=UTF-8');
        }

        $out = [];

        try {
            DB::connection()->getPdo();
        } catch (Throwable $e) {
            return response(
                "Database connection failed.\n\n".
                $e->getMessage()."\n\n".
                "Check DB_* values in .env (DB_HOST/DB_DATABASE/DB_USERNAME/DB_PASSWORD).\n",
                500
            )->header('Content-Type', 'text/plain; charset=UTF-8');
        }

        try {
            $out[] = "Running: php artisan migrate --force";
            Artisan::call('migrate', ['--force' => true]);
            $out[] = trim((string) Artisan::output());

            $out[] = "Running: php artisan db:seed --force";
            Artisan::call('db:seed', ['--force' => true]);
            $out[] = trim((string) Artisan::output());

            $adminEmail = trim((string) env('ADMIN_EMAIL', 'admin@twinbot.local'));
            $adminName = trim((string) env('ADMIN_NAME', 'Admin'));
            $adminPasswordEnv = (string) env('ADMIN_PASSWORD', '');
            $generatedPassword = false;

            $adminPassword = $adminPasswordEnv;
            if ($adminPassword === '') {
                $adminPassword = Str::password(16);
                $generatedPassword = true;
            }

            User::updateOrCreate(
                ['email' => $adminEmail],
                [
                    'name' => $adminName !== '' ? $adminName : 'Admin',
                    'password' => Hash::make($adminPassword),
                ]
            );

            $out[] = "Admin email: {$adminEmail}";
            if ($generatedPassword) {
                $out[] = "Admin password (generated): {$adminPassword}";
            } else {
                $out[] = "Admin password set from ADMIN_PASSWORD (not displayed).";
            }
        } catch (Throwable $e) {
            $out[] = "ERROR: ".$e->getMessage();

            return response(implode("\n\n", array_filter($out))."\n", 500)
                ->header('Content-Type', 'text/plain; charset=UTF-8');
        }

        @file_put_contents($lockPath, 'installed_at='.date('c')."\n");

        $out[] = "OK. Lock file created: storage/app/install.lock";
        $out[] = "Next: open /admin/login and sign in.";
        $out[] = "Security: remove INSTALL_TOKEN from .env after this (and ADMIN_PASSWORD if you set one).";

        return response(implode("\n\n", array_filter($out))."\n", 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
