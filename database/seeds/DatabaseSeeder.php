<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        if (!$this->onProduction()) {
            $this->call(Playlists::class);
            $this->call(Videos::class);
        }
    }

    /**
     * @return bool
     */
    protected function onProduction(): bool
    {
        return env('APP_ENV') === 'production';
    }
}
